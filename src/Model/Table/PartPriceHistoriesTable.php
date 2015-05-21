<?php
namespace App\Model\Table;

use App\Model\Entity\PartPriceHistory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
// use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartPriceHistories Model
 */
class PartPriceHistoriesTable extends AppTable
{
    public $fields = [
        'date_changed' => [
            
        ],
        'price' => [
            'display_field' => false,
            'check' => false
        ]
    ];
    
    public $assocs = [
        'PartVendors'
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('part_price_histories');
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
            ->add('date_changed', 'valid', ['rule' => 'datetime'])
            ->requirePresence('date_changed', 'create')
            ->notEmpty('date_changed')
            ->add('price', 'valid', ['rule' => 'decimal'])
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
}
