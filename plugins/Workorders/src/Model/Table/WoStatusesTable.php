<?php
namespace Workorders\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Workorders\Model\Entity\WoStatus;

/**
 * WoStatuses Model
 */
class WoStatusesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('wo_statuses');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('Workorders', [
            'foreignKey' => 'wo_status_id',
            'className' => 'Workorders.Workorders'
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
            ->requirePresence('wo_status', 'create')
            ->notEmpty('wo_status');

        return $validator;
    }
}
