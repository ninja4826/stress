<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\WoTaskUpdateHistory;

/**
 * WoTaskUpdateHistories Model
 */
class WoTaskUpdateHistoriesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('wo_task_update_histories');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('WoTasks', [
            'foreignKey' => 'wo_task_id',
            'className' => 'Workorders.WoTasks'
        ]);
        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'className' => 'Workorders.Staffs'
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
            ->add('wo_task_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('wo_task_id', 'create')
            ->notEmpty('wo_task_id')
            ->add('staff_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('staff_id', 'create')
            ->notEmpty('staff_id')
            ->requirePresence('update_type', 'create')
            ->notEmpty('update_type')
            ->add('date_modified', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_modified', 'create')
            ->notEmpty('date_modified');

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
        $rules->add($rules->existsIn(['wo_task_id'], 'WoTasks'));
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'));
        return $rules;
    }
}
