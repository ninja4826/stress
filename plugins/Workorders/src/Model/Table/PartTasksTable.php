<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\PartTask;

/**
 * PartTasks Model
 */
class PartTasksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('part_tasks');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Parts', [
            'foreignKey' => 'part_id',
            'className' => 'Parts'
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
            ->add('quantity', 'valid', ['rule' => 'numeric'])
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity')
            ->add('task_date', 'valid', ['rule' => 'datetime'])
            ->requirePresence('task_date', 'create')
            ->notEmpty('task_date')
            ->add('part_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('part_id', 'create')
            ->notEmpty('part_id');

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
        $rules->add($rules->existsIn(['part_id'], 'Parts'));
        return $rules;
    }
}
