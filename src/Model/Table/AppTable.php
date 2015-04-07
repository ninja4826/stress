<?php
namespace App\Model\Table;

use App\Model\Entity\AppEntity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Log\Log;

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
}