<?php
namespace App\Model\Table;

use App\Model\Entity\Location;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Locations Model
 */
class LocationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('locations');
        $this->displayField('location_name');
        $this->primaryKey('id');
        $this->hasMany('Parts', [
            'foreignKey' => 'location_id'
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
            ->requirePresence('isle', 'create')
            ->notEmpty('isle')
            ->add('seg', 'valid', ['rule' => 'numeric'])
            ->requirePresence('seg', 'create')
            ->notEmpty('seg')
            ->requirePresence('shelf', 'create')
            ->notEmpty('shelf')
            ->add('box', 'valid', ['rule' => 'numeric'])
            ->requirePresence('box', 'create')
            ->notEmpty('box')
            ->requirePresence('shelf', 'create')
            ->requirePresence('location_name', 'create')
            ->notEmpty('location_name');

        return $validator;
    }
    
    public function processName($location)
    {
        $data = $location;
        $loc = $data;
        if (!is_null($loc['location_name']))
        {
            if (is_null($loc['location_name']))
            {
                return false;
            }
            
            $loc = [
                'location_name' => $loc['location_name'],
                'isle' => '',
                'seg' => '',
                'shelf' => '',
                'box' => ''
            ];
            
            $locs_arr = str_split($loc['location_name']);
            
            preg_match_all(
                "/[a-zA-Z]/",
                implode($locs_arr),
                $shelf_loc,
                PREG_OFFSET_CAPTURE
            );
            
            $loc['isle'] = $shelf_loc[0][0][0];
            $loc['shelf'] = $shelf_loc[0][1][0];
            
            unset($locs_arr[$shelf_loc[0][0][1]]);
            unset($locs_arr[$shelf_loc[0][1][1]]);
            
            $box_b = false;
            $prev_loc = 0;
            $locs_remaining = array_keys($locs_arr);
            
            foreach ($locs_remaining as $locs)
            {
                if ($prev_loc != ($locs - 1))
                {
                    $box_b = true;
                }
                
                if ($box_b)
                {
                    $loc['box'] .= $locs_arr[$locs];
                } else {
                    $loc['seg'] .= $locs_arr[$locs];
                }
                
                $prev_loc = $locs;
            }
        }
        
        if (!is_null($loc['isle']) && !is_null($loc['seg']) && !is_null($loc['shelf']) && !is_null($loc['box']) && !is_null($loc['location_name']))
        {
            $loc['seg'] = (int)$loc['seg'];
            $loc['box'] = (int)$loc['box'];
            $data = $loc;
            
            return $this->newEntity($data);
        } else {
            return null;
        }
    }
}
