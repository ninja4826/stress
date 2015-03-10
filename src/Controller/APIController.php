<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * API Controller
 *
 * @property \App\Model\Table\APITable $API
 */
class APIController extends AppController
{
    
    private $tables = [
        'Parts',
        'Categories',
        'CostCenters',
        'Locations',
        'Manufacturers',
    ];
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function search($model = null) {
        $this->layout = 'ajax';
        $this->RequestHandler->renderAs($this, 'json');
        if (!in_array($model, $this->tables)) {
            $this->set('items', ['error' => 'Model does not exist.', 'model' => $model, 'tables' => $this->tables]);
            $this->set('_serialize', ['items']);
            return;
        }
        $this->loadModel($model);
        $q = $this->request->query;
        
        $items = $this->$model->find('all');
        
        if (array_key_exists('conditions', $q)) {
            $conditions = json_decode($q['conditions'], true);
            foreach ($conditions as $k => $v) {
                $items->where([$k => $v]);
            }
        }
        
        if (array_key_exists('fields', $q)) {
            $items->select(json_decode($q['fields'], true));
        }
        
        if (array_key_exists('limit', $q)) {
            $items->limit($q['limit']);
        }
        $this->set('items', $items->toArray());
        $this->set('_serialize', ['items']);
    }
    
    public function keyword_search() {
        if (!$this->request->is('post') || empty($this->request->data['keyword'])) {
            $this->redirect($this->referer());
        }
        $this->set('key', [$this->request->data['keyword']]);
    }
    
    public function advanced_search() {
        $this->set('test', 'testasdf');
    }
    
    public function test() {
        // $this->request->onlyAllow('ajax');
        // $this->loadComponent('Ajax');
        $this->viewClass = 'Ajax.Ajax';
        $blah = ['sdoib' => 'asdf'];
        $this->set('blah', $blah);
        $this->set('_serialize', 'blah');
    }
}
