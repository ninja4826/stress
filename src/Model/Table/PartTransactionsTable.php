<?php
namespace App\Model\Table;

use App\Model\Entity\PartTransaction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartTransactions Model
 */
class PartTransactionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('part_transactions');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('PartVendors', [
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
            ->add('part_vendor_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('part_vendor_id', 'create')
            ->notEmpty('part_vendor_id')
            ->add('order_num', 'valid', ['rule' => 'numeric'])
            ->requirePresence('order_num', 'create')
            ->notEmpty('order_num')
            ->add('date', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date', 'create')
            ->notEmpty('date')
            ->add('change_qty', 'valid', ['rule' => 'numeric'])
            ->requirePresence('change_qty', 'create')
            ->notEmpty('change_qty')
            ->add('price', 'valid', ['rule' => 'numeric'])
            ->requirePresence('price', 'create')
            ->notEmpty('price');

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
        $rules->add($rules->existsIn(['part_vendor_id'], 'PartVendors'));
        return $rules;
    }
}
