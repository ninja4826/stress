<?php
namespace App\Model\Table;

use App\Model\Entity\PartVendor;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
// use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * PartVendors Model
 */
class PartVendorsTable extends AppTable
{

    public $assocs = [
        'Parts',
        'Vendors'
    ];
    
    public $fields = [
        'vendor' => [],
        'part' => [],
        'markup' => [],
        'discount' => [
            'type' => 'number'
        ],
        'preferred' => [],
    ];
    
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('part_vendors');
        $this->displayField('vendor_name');
        $this->primaryKey('id');
        $this->belongsTo('Parts', [
            'foreignKey' => 'part_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PVRateHistories', [
            'foreignKey' => 'part_vendor_id'
        ]);
        $this->hasMany('PartPriceHistories', [
            'foreignKey' => 'part_vendor_id'
        ]);
        $this->hasMany('PartTransactions', [
            'foreignKey' => 'part_vendor_id'
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
            ->requirePresence('vendor_name', 'create')
            ->notEmpty('vendor_name')
            ->requirePresence('markup', 'create')
            ->notEmpty('markup')
            ->add('discount', 'valid', ['rule' => 'decimal'])
            ->requirePresence('discount', 'create')
            ->notEmpty('discount')
            ->add('preferred', 'valid', ['rule' => 'boolean'])
            ->requirePresence('preferred', 'create')
            ->notEmpty('preferred');

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
        $rules->add($rules->existsIn(['part_id'], 'Parts'));
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));
        return $rules;
    }
    
    public function beforeMarshal($event, $data, $options) {
        if (!array_key_exists('vendor_id', $data)) {
            return false;
        }
        Log::write('debug', 'PARTVENDOR STUFF');
        Log::write('debug', $data);
        $vendors = TableRegistry::get('Vendors');
        $data['vendor_name'] = $this->Vendors->get($data['vendor_id'])->vendor_name;
        Log::write('debug', $data);
        return true;
    }
}
