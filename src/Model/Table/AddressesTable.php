<?php
namespace App\Model\Table;

use App\Model\Entity\Address;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Addresses Model
 */
class AddressesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('addresses');
        $this->displayField('id');
        $this->primaryKey('id');
        
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
            ->requirePresence('street_address', 'create')
            ->notEmpty('street_address')
            ->requirePresence('city', 'create')
            ->notEmpty('city')
            ->add('zip_code', 'valid', ['rule' => 'numeric'])
            ->requirePresence('zip_code', 'create')
            ->notEmpty('zip_code')
            ->requirePresence('country', 'create')
            ->notEmpty('country')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        return $validator;
    }
}
