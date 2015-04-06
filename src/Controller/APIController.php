<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class APIController extends AppController {
    public $response_var = [];
    public $status = false;
    
    private $tables = [
        'Parts',
        'Categories',
        'CostCenters',
        'Locations',
        'Manufacturers'
    ];
    
    public function initialize() {
        parent::initialize();
        // $this->loadComponent('Bootstrap.Flash');
        // $this->helpers[] = 'Less.Less';
        // $this->helpers[] = 'Bootstrap.Form';
        // $this->layout = 'default';
        $this->loadComponent('RequestHandler');
    }
    
    public function main_func($func) {
        
        $this->$func();
        
        if ($this->layout == 'ajax') {
            $this->RequestHandler->renderAs($this, 'json');
        }
        $this->response_var['status'] = ($this->status ? 'ok' : 'error');
        $this->set('response', $this->response_var);
        $this->set('_serialize', ['response']);
    }
    
    public function git_pull() {
        $this->viewClass = 'Json';
        $LOCAL_ROOT = "/var/www";
        $LOCAL_REPO_NAME = "stress";
        $LOCAL_REPO = "{$LOCAL_ROOT}/{$LOCAL_REPO_NAME}";
        $REMOTE_REPO = "git@github.com:ninja4826/stress.git";
        $BRANCH = "master";

        if ($this->request->is('post')) {
            if (file_exists($LOCAL_REPO)) {

                Log::write('debug', `git -C /var/www/stress pull 2>&1`);
                Log::write('debug', 'PULLING');
            } else {
            }
        }
        
        $this->response_var = ['blah'];
    }
    
    public function search() {
        $this->loadComponent('RequestHandler');
        $this->viewClass = 'Json';
        // Log::write('debug', $this->request->query);
        if (!array_key_exists('q', $this->request->query)) {
            return;
        }
        $response = [];
        $q = json_decode($this->request->query['q'], true);
        // Log::write('debug', $q);
        foreach ($q as $model => $options) {
            $this->loadModel($model);

            // $item = $this->$model->find('all', ['limit' => 1])->toArray()[0];
            $query = null;

            if (array_key_exists('fields', $options)) {
                foreach(['id', $this->$model->displayField()] as $field) {
                    if (!in_array($field, $options['fields'])) {
                        $options['fields'][] = $field;
                    }
                }
            }
            if (array_key_exists('id', $options)) {
                $id = $options['id'];
                unset($options['id']);
                $query = $this->$model->get($id, $options);
            } else {
                // $query = $this->$model->find('all', $options)->toArray();
                $query = $this->$model->getCached();
            }
            $response[$model] = $query;

        }
        $this->status = true;
        $this->response_var = $response;
    }
    
    public function add_modal() {
        Log::write('debug', 'ADD MODAL CALLED');
        $this->viewClass = 'Json';
        $model = $this->request->query['model'];
        if ($this->request->is('post')) {
            $this->loadModel($model);
            $item = $this->$model->newEntity($this->request->data);
            if ($this->$model->save($item)) {
                // $this->set('response', ['status' => 'ok', 'data' => $this->request->data, 'item' => $item]);
                
                $this->response_var = ['data' => $this->request->data, 'item' => $item];
                $this->status = true;
            } else {
                // $this->set('response', ['status' => 'error', 'data' => $this->request->data]);
                
                $this->response_var = ['data' => $this->request->data];
            }
            // $this->set('_serialize', ['response']);
            return;
        }
        $this->render('/Element/modals/' . $model . '/add');
    }
    
    public function test_search() {
        $this->layout = 'ajax';
        $arr = [
            'Parts' => [
                [
                    'or' => [
                        [
                            'name' => 'amt_on_hand',
                            'op' => '<',
                            'val' => 30
                        ],
                        [
                            'name' => 'part_num',
                            'op' => 'k',
                            'val' => 'SN'
                        ]
                    ]
                ]
            ]
        ];
        $this->loadComponent('Search');
        $resp = $this->Search->search($arr);
        Log::write('debug', $resp['Parts']->toArray());
        $this->response_var = [$resp];
    }
}