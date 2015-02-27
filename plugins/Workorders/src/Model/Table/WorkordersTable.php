<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\Workorder;

/**
 * Workorders Model
 */
class WorkordersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('workorders');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('WoStatuses', [
            'foreignKey' => 'wo_status_id',
            'className' => 'Workorders.WoStatuses',
            'propertyName' => 'wo_status'
        ]);
        $this->belongsTo('WoTypes', [
            'foreignKey' => 'wo_type_id',
            'className' => 'Workorders.WoTypes',
            'propertyName' => 'wo_type'
        ]);
        $this->belongsTo('Staffs', [
            'foreignKey' => 'pm_id',
            'className' => 'Staffs',
            'propertyName' => 'project_manager'
        ]);
        $this->belongsTo('Staffs', [
            'foreignKey' => 'req_id',
            'className' => 'Staffs',
            'propertyName' => 'requestor'
        ]);
        $this->hasMany('Permissions', [
            'foreignKey' => 'workorder_id',
            'className' => 'Permissions',
            'propertyName' => 'permissions'
        ]);
        $this->hasMany('WoTasks', [
            'foreignKey' => 'workorder_id',
            'className' => 'Workorders.WoTasks',
            'propertyName' => 'wo_tasks'
        ]);
        $this->hasMany('WoUpdateHistories', [
            'foreignKey' => 'workorder_id',
            'className' => 'Workorders.WoUpdateHistories',
            'propertyName' => 'wo_update_histories'
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
            ->add('date_received', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_received', 'create')
            ->notEmpty('date_received')
            ->add('date_required', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_required', 'create')
            ->notEmpty('date_required')
            ->add('expedite', 'valid', ['rule' => 'boolean'])
            ->requirePresence('expedite', 'create')
            ->notEmpty('expedite')
            ->requirePresence('description', 'create')
            ->notEmpty('description')
            ->requirePresence('location', 'create')
            ->notEmpty('location')
            ->add('date_signed', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_signed', 'create')
            ->notEmpty('date_signed')
            ->add('fixed_price', 'valid', ['rule' => 'decimal'])
            ->requirePresence('fixed_price', 'create')
            ->notEmpty('fixed_price')
            ->add('date_promised', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_promised', 'create')
            ->notEmpty('date_promised')
            ->requirePresence('est_time', 'create')
            ->notEmpty('est_time')
            ->add('wo_status_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('wo_status_id', 'create')
            ->notEmpty('wo_status_id')
            ->add('wo_type_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('wo_type_id', 'create')
            ->notEmpty('wo_type_id')
            ->add('project_number', 'valid', ['rule' => 'numeric'])
            ->requirePresence('project_number', 'create')
            ->notEmpty('project_number')
            ->add('pm_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('pm_id', 'create')
            ->notEmpty('pm_id')
            ->add('req_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('req_id', 'create')
            ->notEmpty('req_id')
            ->requirePresence('wo_req', 'create')
            ->notEmpty('wo_req');

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
        $rules->add($rules->existsIn(['wo_status_id'], 'WoStatuses'));
        $rules->add($rules->existsIn(['wo_type_id'], 'WoTypes'));
        $rules->add($rules->existsIn(['pm_id'], 'Pms'));
        $rules->add($rules->existsIn(['req_id'], 'Reqs'));
        return $rules;
    }
}
