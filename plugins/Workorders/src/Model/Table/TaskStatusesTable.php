<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\TaskStatus;

/**
 * TaskStatuses Model
 */
class TaskStatusesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('task_statuses');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('WoTasks', [
            'foreignKey' => 'task_status_id',
            'className' => 'Workorders.WoTasks'
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
            ->requirePresence('task_status', 'create')
            ->notEmpty('task_status');

        return $validator;
    }
}
