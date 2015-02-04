<?php
namespace App\Model\Table;

use App\Model\Entity\Location;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 */
class LocationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('locations');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->hasMany('Parts', [
            'foreignKey' => 'location_id'
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
            ->requirePresence('isle', 'create')
            ->notEmpty('isle')
            ->add('seg', 'valid', ['rule' => 'numeric'])
            ->requirePresence('seg', 'create')
            ->notEmpty('seg')
            ->requirePresence('shelf', 'create')
            ->notEmpty('shelf')
            ->add('box', 'valid', ['rule' => 'numeric'])
            ->requirePresence('box', 'create')
            ->notEmpty('box')
            ->requirePresence('shelf', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
