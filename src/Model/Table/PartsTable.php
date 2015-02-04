<?php
namespace App\Model\Table;

use App\Model\Entity\Part;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Parts Model
 */
class PartsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('parts');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Manufacturers', [
            'foreignKey' => 'manufacturer_id'
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id'
        ]);
        $this->belongsTo('CostCenters', [
            'foreignKey' => 'cc_id'
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
            ->add('manufacturer_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('manufacturer_id', 'create')
            ->notEmpty('manufacturer_id')
            ->add('category_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('category_id', 'create')
            ->notEmpty('category_id')
            ->requirePresence('part_num', 'create')
            ->notEmpty('part_num')
            ->requirePresence('description', 'create')
            ->notEmpty('description')
            ->add('amt_on_hand', 'valid', ['rule' => 'numeric'])
            ->requirePresence('amt_on_hand', 'create')
            ->notEmpty('amt_on_hand')
            ->add('location_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('location_id', 'create')
            ->notEmpty('location_id')
            ->add('active', 'valid', ['rule' => 'boolean'])
            ->requirePresence('active', 'create')
            ->notEmpty('active')
            ->add('cc_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('cc_id', 'create')
            ->notEmpty('cc_id');

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
        $rules->add($rules->existsIn(['manufacturer_id'], 'Manufacturers'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['cc_id'], 'CostCenters'));
        return $rules;
    }
    
    public function beforeMarshal($data, $options)
    {
        if (is_null($options['location_name']))
        {
            return false;
        }
        
        $loc_table = TableRegistry::get('Locations');
        
        $location = $loc_table->findByName($options['location_name'])->first();
        
        if(is_null($location))
        {
            $location = $loc_table->newEntity(['name' => $options['location_name']]);
            
            if ($loc_table->save($location))
            {
                $options['location_id'] = $location['id'];
                if ($options['location_id'] == $location['id'])
                {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $options['location_id'] = $location['id'];
            
            if ($options['location_id'] == $location['id'])
            {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
