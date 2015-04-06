<?php
namespace App\Model\Table;

use App\Model\Entity\AppEntity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Log\Log;

class AppTable extends Table {
    public function afterSave(Event $event, $entity, $options) {
        $query = $this->find('all', ['contain' => $this->assocs]);
        $query->cache($this->table().'_all');
        $query->toArray();
        return true;
    }
    
    public function getCached() {
        $cache = Cache::read($this->table().'_all');
        if ($cache !== false) {
            return $cache->toArray();
        } else {
            return [];
        }
    }
}