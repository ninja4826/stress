<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\WoTask;

/**
 * WoTasks Model
 */
class WoTasksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('wo_tasks');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Workorders', [
            'foreignKey' => 'workorder_id',
            'className' => 'Workorders.Workorders'
        ]);
        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'className' => 'Staffs'
        ]);
        $this->belongsTo('TaskStatuses', [
            'foreignKey' => 'task_status_id',
            'className' => 'Workorders.TaskStatuses'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'className' => 'Workorders.Tasks'
        ]);
        $this->hasMany('WoTaskUpdateHistories', [
            'foreignKey' => 'wo_task_id',
            'className' => 'Workorders.WoTaskUpdateHistories'
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
            ->add('workorder_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('workorder_id', 'create')
            ->notEmpty('workorder_id')
            ->add('staff_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('staff_id', 'create')
            ->notEmpty('staff_id')
            ->add('task_status_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_status_id', 'create')
            ->notEmpty('task_status_id')
            ->add('task_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_id', 'create')
            ->notEmpty('task_id');

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
        $rules->add($rules->existsIn(['workorder_id'], 'Workorders'));
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'));
        $rules->add($rules->existsIn(['task_status_id'], 'TaskStatuses'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        return $rules;
    }
}
