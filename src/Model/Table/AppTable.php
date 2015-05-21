<?php
namespace App\Model\Table;

use App\Model\Entity\AppEntity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class AppTable extends Table {
    
    public $assocs = [];
    
    // public function afterSave(Event $event, $entity, $options) {
    public function afterSaveCommit(Event $event, $entity, $options) {
        $this->update_cache();
    }
    
    public function afterDeleteCommit(Event $event, $entity, $options) {
        $this->update_cache();
    }
    
    public function getCached() {
        $cache = Cache::read($this->table().'_all');
        if ($cache !== false) {
            return $cache->toArray();
        } else {
            return [];
        }
    }
    
    protected function update_cache() {
        $query = $this->find('all', ['contain' => $this->assocs]);
        Cache::delete($this->table().'_all');
        $query->cache($this->table().'_all');
        $query->toArray();
        return true;
    }
    
    public function findAssoc(Query $query, array $options) {
        return $query->contain($this->assocs);
    }
    
    public function getFields() {
        $entity = $this->find('assoc', ['limit' => 1])->first();
        $error = $this->newEntity([])->errors();
        $virtual = $entity->_virtual;
        $fields = [];
        Log::write('debug', 'GETTING FIELDS');
        foreach($entity->toArray() as $name => $val) {
            if (!in_array($name, $virtual) && substr($name, -3) != '_id' && $name != 'id') {
                $field = [];
                $type = gettype($val);
                if ($type != 'array') {
                    $field['default'] = '';
                    Log::write('debug', $name.' | TYPE: '.$type);
                    switch($type) {
                        case 'string':
                            $field['type'] = 'text';
                            $field['search'] = true;
                            break;
                        case 'boolean':
                            $field['type'] = 'checkbox';
                            $field['default'] = '0';
                            $field['search'] = false;
                            break;
                        case 'integer':
                            $field['type'] = 'number';
                            $field['search'] = false;
                            break;
                        case 'double':
                            $field['type'] = 'number';
                            $field['search'] = false;
                            break;
                        case 'array':
                            $plural = Inflector::pluralize($name);
                            if ($plural == $name) {
                                $field['type'] = 'hasMany';
                            } else {
                                $field['type'] = 'belongsTo';
                            }
                            break;
                        default:
                            if (is_a($val, 'Cake\I18n\Time')) {
                                $field['type'] = 'date';
                            } else {
                                $field['type'] = 'null';
                            }
                    }
                    $field['required'] = array_key_exists($name, $error);
                    $field['field_name'] = $name;
                } else {
                    Log::write('debug', 'IS ASSOC');
                    Log::write('debug', $name);
                    $field['search'] = false;
                    $field['type'] = 'text';
                    $field['required'] = true;
                    if (gettype($entity->$name) == 'array') {
                        $assoc_f = $entity->$name;
                        $field['assoc'] = [
                            'model' => Inflector::camelize($assoc_f[0]->table_name),
                            'type' => 'belongsToMany'
                        ];
                    } else {
                        $field['assoc'] = [
                            'model' => Inflector::camelize($entity->$name->table_name),
                            'type' => (Inflector::pluralize($name) == $name ? 'hasMany' : 'belongsTo'),
                            'key' => $name.'_id'
                        ];
                    }
                    $field['type'] = 'text';
                    $foreign_display = TableRegistry::get($field['assoc']['model'])->find('all', ['limit' => 1])->first()->display_field;
                    $field['assoc']['display_field'] = $foreign_display;
                    $field['default'] = '';
                }
                $field['label'] = Inflector::humanize($name);
                $fields[$name] = $field;
            }
        }
        if (isset($entity->display_field)) {
            $fields[$entity->display_field]['check'] = true;
            $fields[$entity->display_field]['display_field'] = true;
            $fields[$entity->display_field]['unique'] = true;
        }
        $fields = $this->editFields($fields);
        foreach($fields as $field_name => $field) {
            if (array_key_exists('assoc', $field) && !$field['assoc']) {
                unset($fields[$field_name]['assoc']);
            }
        }
        return $fields;
    }
    
    protected function editFields(array $fields = []) {
        $temp_fields = $fields;
        if (isset($this->fields)) {
            $temp_fields = $this->field_merge(array_intersect_key($fields, $this->fields), $this->fields);
            uksort($temp_fields, [$this, 'sort_fields']);
        }
        return $temp_fields;
    }
    
    public function sort_fields($a, $b) {
        $fields = array_keys($this->fields);
        $a_i = array_search($a, $fields);
        $b_i = array_search($b, $fields);
        if ($a_i > $b_i) {
            return 1;
        } elseif($a_i == $b_i) {
            return 0;
        } elseif($a_i < $b_i) {
            return -1;
        } else {
            return 0;
        }
    }
    
    public function field_merge(array $first, array $second) {
        foreach ($second as $key => $val) {
            if (gettype($val) == 'array' && array_key_exists($key, $first)) {
                $first[$key] = $this->field_merge($first[$key], $val);
            } else {
                $first[$key] = $val;
            }
        }
        return $first;
    }
}



























  