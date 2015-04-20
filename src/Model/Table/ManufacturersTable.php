<?php
namespace App\Model\Table;

use App\Model\Entity\Manufacturer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
// use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;

/**
 * Manufacturers Model
 */
class ManufacturersTable extends AppTable
{
    
    public $indexes = ['manufacturer_name'];
    
    public $fields = [
        'manufacturer_name' => [],
        'active' => [],
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('manufacturers');
        $this->displayField('manufacturer_name');
        $this->primaryKey('id');
        $this->hasMany('Parts', [
            'foreignKey' => 'manufacturer_id'
        ]);
        
        // $this->addBehavior('Search', [
        //     'fields' => [
        //         'manufacturer_name' => 'string',
        //         'active' => true
        //     ]
        // ]);
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
            ->add('manufacturer_name', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table'
                ]
            ])
            ->requirePresence('manufacturer_name', 'create')
            ->notEmpty('manufacturer_name')
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }
}
