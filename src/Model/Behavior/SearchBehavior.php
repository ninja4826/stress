<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\Log\Log;

class SearchBehavior extends Behavior {
    
    /**
     * $fields = [
     *     'field' => 'type' 
     * ]
     */
    public $fields = [];
    
    public $table_fields = [];
    
    public function initialize(array $config) {
        $this->table_fields = $config['fields'];
    }
    
    public function findSearch(Query $query, array $options) {
        // Add differentiation of 'all' type or specific inputs
        if (!array_key_exists('fields', $options)) {
            return $query;
        } else {
            $fields = $options['fields'];
            foreach ($fields as $field => $value) {
                if ($field === 'all') {
                    Log::write('debug', $value);
                }
            }
        }
        return $query;
    }
    
    public function findSearch(Query $query, array $options) {
        foreach ($options as $field => $value) {
            if ($field === 'all') {
                
            }
        }
    }
    
    private function _search_all(Query $query, array $options) {
        debug($options);
        debug($query);
        $fields = [];
        $k = null;
        $value = null;
        $type = null;
        if (!array_key_exists('k', $options)) {
            return $query;
        } else {
            $k = $options['k'];
            if (array_key_exists('value', $k)) {
                $value = $k['value'];
                $type = gettype($value);
            } else {
                return $query;
            }
        }
        
        $type_found = false;
        
        foreach ($this->table_fields as $field => $prop) {
            if (gettype($prop) === $type) {
                $type_found = true;
                $fields[$field] = "%{$value}%";
            }
        }
        if ($type_found) {
            $where = [];
            foreach($fields as $field => $value) {
                $where['OR'][] = ["Parts.{$field} LIKE" => $value];
            }
            $query->where($where);
        }
        return $query;
    }
    
    
    private function _k_o(Query $query, array $options) {
        
    }
    
}