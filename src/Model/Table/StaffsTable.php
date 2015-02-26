<?php
namespace App\Model\Table;

use App\Model\Entity\Staff;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Staffs Model
 */
class StaffsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('staffs');
        $this->displayField('full_name');
        $this->primaryKey('id');
        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id'
        ]);
        $this->hasOne('Users', [
            'foreignKey' => 'staff_id'
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
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name')
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name')
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active')
            ->add('address_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('address_id', 'create')
            ->notEmpty('address_id')
            ->requirePresence('full_name', 'create')
            ->notEmpty('full_name');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['address_id'], 'Addresses'));
        return $rules;
    }
    
    public function beforeMarshal($event, $data, $options) {
        if (array_key_exists('first_name', $data) && array_key_exists('last_name', $data)) {
            $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'];
            return true;
        }
        return false;
    }
}
