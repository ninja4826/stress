<?php
namespace App\Model\Table;

use App\Model\Entity\Part;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
// use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;
use Search\Manager;

/**
 * Parts Model
 */
class PartsTable extends AppTable
{
    public $assocs = [
        'Locations',
        'Categories',
        'CostCenters',
        'Manufacturers',
    ];
    
    public $fields = [
        'part_num' => [
            'label' => 'Part Number',
            'placeholder' => 'SN74S74N'
        ],
        'description' => [
        ],
        'amt_on_hand' => [
            'label' => 'Amount on Hand'
        ],
        'active' => [
        ],
        'location_name' => [
            'placeholder' => 'G1C2',
            'search' => false
        ],
        'category' => [
            'field_name' => 'category'
        ],
        'cost_center' => [
            'assoc' => [
                'key' => 'cc_id'
            ],
            'field_name' => 'cost_center'
        ],
        // 'manufacturers' => [
        //     'default' => 'blah',
        //     'assoc' => [
        //         'key' => 'manufacturers'
        //     ],
        //     'field_name' => 'manufacturers'
        // ]
        'manufacturer' => [
            'assoc' => [
                'key' => 'manufacturer_id'
            ],
            'field_name' => 'manufacturer'
        ]
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('parts');
        $this->displayField('part_num');
        $this->primaryKey('id');
        $this->belongsTo('Manufacturers', [
            'foreignKey' => 'manufacturer_id'
        ]);
        // $this->belongsToMany('Manufacturers', [
        //     'joinTable' => 'parts_manufacturers',
        //     'saveStrategy' => 'append'
        // ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id'
        ]);
        $this->belongsTo('CostCenters', [
            'foreignKey' => 'cc_id'
        ]);
        $this->hasMany('PartVendors', [
            'foreignKey' => 'part_id'
        ]);
        $this->belongsToMany('PurchaseOrders', [
            'joinTable' => 'parts_purchases'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            // ->add('manufacturer_id', 'valid', ['rule' => 'numeric'])
            // ->requirePresence('manufacturer_id', 'create')
            ->notEmpty('manufacturer_id')
            ->add('category_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('category_id', 'create')
            ->notEmpty('category_id')
            ->add('part_num', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table'
                ]
            ])
            ->requirePresence('part_num', 'create')
            ->notEmpty('part_num')
            ->requirePresence('description', 'create')
            ->notEmpty('description')
            ->add('amt_on_hand', 'valid', ['rule' => 'numeric'])
            ->requirePresence('amt_on_hand', 'create')
            ->notEmpty('amt_on_hand')
            ->requirePresence('part_num', 'create')
            ->notEmpty('part_num')
            ->add('location_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('location_id', 'create')
            ->notEmpty('location_id')
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active')
            ->add('cc_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('cc_id', 'create')
            ->notEmpty('cc_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['manufacturer_id'], 'Manufacturers'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['cc_id'], 'CostCenters'));
        return $rules;
    }
    
    public function beforeMarshal($event, $data, $options)
    {
        if (array_key_exists('active', $data)) {
            if (gettype($data['active']) == 'string') {
                $data['active'] = (($data['active'] == 'true') ? true : false);
            }
        }
        if (!array_key_exists('location_name', $data))
        {
            return false;
        } elseif (array_key_exists('location_id', $data)) {
            return true;
        }
        $loc_table = TableRegistry::get('Locations');
        
        $location = $loc_table->findByLocationName($data['location_name'])->first();
        
        if(is_null($location))
        {
            $location = $loc_table->processName(['location_name' => $data['location_name']]);
            if ($loc_table->save($location))
            {
                $data['location_id'] = $location['id'];
                if ($data['location_id'] == $location['id'])
                {
                    return true;
                    
                } else {
                    return false;
                }
            }
        } else {
            $data['location_id'] = $location['id'];
            
            if ($data['location_id'] == $location['id'])
            {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
