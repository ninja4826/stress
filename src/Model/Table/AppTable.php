<?php
namespace App\Model\Table;

use App\Model\Entity\AppEntity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Utility\Inflector;

class AppTable extends Table {
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
        
        $virtual = $entity->_virtual;
        $fields = [];
        
        foreach($entity->toArray() as $name => $val) {
            if (!in_array($name, $virtual) && substr($name, -3) != '_id') {
                $field = [];
                $type = gettype($val);
                
                switch($type) {
                    case 'string':
                        $type = 'text';
                        break;
                    case 'boolean':
                        $type = 'checkbox';
                        break;
                    case 'integer':
                        $type = 'number';
                        break;
                    case 'array':
                        $plural = Inflector::pluralize($name);
                        if ($plural == $name) {
                            $type = 'hasMany';
                        } else {
                            $type = 'belongsTo';
                        }
                        break;
                    default:
                        $type = 'null';
                }
                $field['type'] = $type;
                
                $fields[$name] = $field;
            }
        }
        return $fields;
    }
}