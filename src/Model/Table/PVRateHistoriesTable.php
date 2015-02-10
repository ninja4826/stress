<?php
namespace App\Model\Table;

use App\Model\Entity\PVRateHistory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PVRateHistories Model
 */
class PVRateHistoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('p_v_rate_histories');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('PVRates', [
            'foreignKey' => 'p_v_rate_id'
        ]);
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
            ->add('p_v_rate_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('p_v_rate_id', 'create')
            ->notEmpty('p_v_rate_id')
            ->add('part_vendor_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('part_vendor_id', 'create')
            ->notEmpty('part_vendor_id')
            ->add('date', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date', 'create')
            ->notEmpty('date')
            ->requirePresence('comment', 'create')
            ->notEmpty('comment');

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
        $rules->add($rules->existsIn(['p_v_rate_id'], 'PVRates'));
        $rules->add($rules->existsIn(['part_vendor_id'], 'PartVendors'));
        return $rules;
    }
}
