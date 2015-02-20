<?php
namespace App\Model\Table;

use App\Model\Entity\PartTransaction;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * PartTransactions Model
 */
class PartTransactionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('part_transactions');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('PartVendors', [
            'foreignKey' => 'part_vendor_id'
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
            ->add('part_vendor_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('part_vendor_id', 'create')
            ->notEmpty('part_vendor_id')
            ->add('order_num', 'valid', ['rule' => 'numeric'])
            ->requirePresence('order_num', 'create')
            ->notEmpty('order_num')
            ->add('date', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date', 'create')
            ->notEmpty('date')
            ->add('change_qty', 'valid', ['rule' => 'numeric'])
            ->requirePresence('change_qty', 'create')
            ->notEmpty('change_qty')
            ->add('price', 'valid', [
                'rule' => 'numeric',
                'on' => function ($context) {
                    return is_int($context);
                }
            ])
            ->add('price', 'valid', [
                'rule' => 'decimal',
                'on' => function ($context) {
                    return is_float($context);
                }
            ])
            ->requirePresence('price', 'create')
            ->notEmpty('price');

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
        $rules->add($rules->existsIn(['part_vendor_id'], 'PartVendors'));
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options) {
        $entity = json_decode(json_encode($entity), true);
        $partPriceHist = TableRegistry::get('PartPriceHistories');
        $transactions = $this->find('all');

        $histories = $partPriceHist->find('all', ['order' => ['date_changed DESC']])->toArray();

        if (!empty($histories) && $histories[0]->toArray()['price'] == $entity['price'])
        {
            return true;
        }

        $hist = $partPriceHist->newEntity([
            'part_vendor_id' => $entity['part_vendor_id'],
            // 'date_changed' => new Time($entity['date']),
            'date_changed' => new Time($entity['date']),
            'price' => $entity['price']
        ]);
        if ($partPriceHist->save($hist)) {
            return true;
        } else {
            return false;
        }
    }

    public function findVendor(Query $query, array $options) {
        if (!empty($options) && array_key_exists('id', $options)) {
            $query->where(['part_vendor_id' => $options['id']]);
        }
        return $query;
    }
}
