<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class SearchBehavior extends Behavior {
    
    /**
     * $fields = [
     *     'field' => 'type' 
     * ]
     */
    public $fields = [];
    
    public function initialize(array $config) {
        $this->fields = $config['fields'];
    }
    
    public function findSearch(Query $query, array $options) {
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
            } else {
                return $query;
            }
            if (array_key_exists('type', $k)) {
                $type = $k['type'];
            } else {
                $type = 'string';
            }
        }
        
        $type_found = false;
        
        foreach ($this->fields as $field => $prop) {
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
}