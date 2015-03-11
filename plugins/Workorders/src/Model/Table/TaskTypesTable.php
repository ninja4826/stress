<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\TaskType;

/**
 * TaskTypes Model
 */
class TaskTypesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('task_types');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('Tasks', [
            'foreignKey' => 'task_type_id',
            'className' => 'Workorders.Tasks'
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
            ->requirePresence('task_type', 'create')
            ->notEmpty('task_type');

        return $validator;
    }
}
