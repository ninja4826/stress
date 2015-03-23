<?php
namespace App\Model\Table;

use App\Model\Entity\CostCenter;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CostCenters Model
 */
class CostCentersTable extends Table
{
    
    public $indexes = ['description'];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('cost_centers');
        $this->displayField('e_code');
        $this->primaryKey('id');
        
        // $this->addBehavior('Search', [
        //     'fields' => [
        //         'e_code' => 'string',
        //         'description' => 'string',
        //         'active' => true,
        //         'default_value' => 'string',
        //         'project_number' => 1
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
            ->requirePresence('e_code', 'create')
            ->notEmpty('e_code')
            ->allowEmpty('description')
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active')
            ->requirePresence('default_value', 'create')
            ->notEmpty('default_value')
            ->add('project_number', 'valid', ['rule' => 'numeric'])
            ->requirePresence('project_number', 'create')
            ->notEmpty('project_number');

        return $validator;
    }
}
