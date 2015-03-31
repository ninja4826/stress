<?php
namespace App\Model\Table;

use App\Model\Entity\PVRate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PVRates Model
 */
class PVRatesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('p_v_rates');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('PVRateHistories', [
            'foreignKey' => 'p_v_rate_id'
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
            ->add('rate', 'valid', ['rule' => 'decimal'])
            ->requirePresence('rate', 'create')
            ->notEmpty('rate');

        return $validator;
    }
}
