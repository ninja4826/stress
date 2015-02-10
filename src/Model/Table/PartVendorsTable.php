<?php
namespace App\Model\Table;

use App\Model\Entity\PartVendor;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartVendors Model
 */
class PartVendorsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('part_vendors');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Parts', [
            'foreignKey' => 'part_id'
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id'
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
            ->add('part_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('part_id', 'create')
            ->notEmpty('part_id')
            ->add('vendor_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('vendor_id', 'create')
            ->notEmpty('vendor_id')
            ->requirePresence('markup', 'create')
            ->notEmpty('markup')
            ->add('discount', 'valid', ['rule' => 'numeric'])
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
}
