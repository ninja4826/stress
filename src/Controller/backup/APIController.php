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
    
    public $response_var;

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

    // public function search($model = null) {
    //     $this->layout = 'ajax';
    //     $this->RequestHandler->renderAs($this, 'json');
    //     if (!in_array($model, $this->tables)) {
    //         $this->set('items', ['error' => 'Model does not exist.', 'model' => $model, 'tables' => $this->tables]);
    //         $this->set('_serialize', ['items']);
    //         return;
    //     }
    //     $this->loadModel($model);
    //     $q = $this->request->query;

    //     $items = $this->$model->find('all');

    //     if (array_key_exists('conditions', $q)) {
    //         $conditions = json_decode($q['conditions'], true);
    //         foreach ($conditions as $k => $v) {
    //             $items->where([$k => $v]);
    //         }
    //     }

    //     if (array_key_exists('fields', $q)) {
    //         $items->select(json_decode($q['fields'], true));
    //     }

    //     if (array_key_exists('limit', $q)) {
    //         $items->limit($q['limit']);
    //     }
    //     $this->set('items', $items->toArray());
    //     $this->set('_serialize', ['items']);
    // }

    public function get_all() {
        $this->viewClass = 'Json';

        $q = $this->request->query;

        if (empty($q) || !array_key_exists('models', $q)) {
            return;
        }

        $models = json_decode($q['models'], true);

        foreach($models as $model => $fields) {
            $this->loadModel($model);

            $display_field = $this->$model->find('all', ['limit' => 1, 'fields' => []])->toArray()[0]->display_field;

            if (!in_array($display_field, $fields)) {
                $fields[] = $display_field;
            }
            if (!in_array('id', $fields)) {
                $fields[] = 'id';
            }

            $objs_ = $this->$model->find('all', ['fields' => $fields])->toArray();

            $objs = [];

            foreach($objs_ as $obj) {
                $obj = $obj->toArray();

                $obj_id = $obj['id'];
                unset($obj['id']);
                $objs[$obj_id] = $obj;
            }
            $response[$model] = $objs;
        }

        $this->set('response', $this->Parts->getPartNums());
        $this->set('_serialize', ['response']);
    }

    public function git_pull() {
        $this->loadComponent('RequestHandler');
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
        
        Log::write('debug', 'GITHUB HOOK ACTIVATED');
        $blah = ['blah'];
        $this->set('blah', $blah);
        $this->set('_serialize', ['blah']);

    }

    public function search() {
        $this->loadComponent('RequestHandler');
        $this->viewClass = 'Json';
        Log::write('debug', $this->request->query);
        if (!array_key_exists('q', $this->request->query)) {
            return;
        }
        $response = [];
        $q = json_decode($this->request->query['q'], true);
        Log::write('debug', $q);
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
                $query = $this->$model->find('all', $options)->toArray();
            }
            $response[$model] = $query;
            Log::write('debug', $response);

        }
        $this->response_var = $response;
        // $this->set('response', $response);
        // $this->set('_serialize', ['response']);
    }
    public function add_modal() {
        $this->viewClass = 'Json';
        $model = $this->request->query['model'];
        if ($this->request->is('post')) {
            $this->loadModel($model);
            $item = $this->$model->newEntity($this->request->data);
            if ($this->$model->save($item)) {
                $this->set('response', ['status' => 'ok', 'data' => $this->request->data, 'item' => $item]);
                
                $this->response_var = ['status' => 'ok', 'data' => $this->request->data, 'item' => $item];
            } else {
                $this->set('response', ['status' => 'error', 'data' => $this->request->data]);
                
                $this->response_var = ['status' => 'error', 'data' => $this->request->data];
            }
            $this->set('_serialize', ['response']);
            return;
        }
        $this->render('/Element/modals/' . $model . '/add');
    }
    
    // public function search() {
    //     // $this->layout = 'ajax';
    //     // $this->loadComponent('RequestHandler');
    //     // $this->viewClass = 'Json';
    //     // $this->RequestHandler->renderAs($this, 'json');
        
    //     // $q;
    //     // if (!in_array('q', $this->request->query)) {
    //     //     $this->status = false;
    //     //     return;
    //     // } else {
    //     //     $q = json_decode($this->request->query['q'], true);
    //     //     if (is_null($q)) {
    //     //         $this->status = false;
    //     //         return;
    //     //     }
    //     // }
    //     $this->response_var['blah'] = 'asdf';
    //     // $this->set('status', 'ok');
    //     // $this->set('response', ['blah' => 'asdf']);
    //     // $this->set('_serialize', ['status', 'response']);
    // }
    
    public function main_func($func) {
        $this->layout = 'ajax';
        $this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
        
        $this->$func();
        
        $this->set('response', $this->response_var);
        $this->set('_serialize', ['response']);
    }
}
