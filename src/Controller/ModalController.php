<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Utility\Inflector;

class ModalController extends AppController {
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    public function form() {
        $this->loadComponent('Csrf', [
            'secure' => false
        ]);
        $this->layout = 'empty';
        $options = $this->request->query;
        $model = $options['model'];
        $this->loadModel($model);
        // $fields = $this->$model->fields;
        $fields = $this->$model->getFields();
        if ($this->request->is('post')) {
            $this->layout = 'ajax';
            $this->RequestHandler->renderAs($this, 'json');
            $data = $this->request->data;
            $entity = $this->$model->newEntity($data);
            if ($this->$model->save($entity)) {
                $this->status = 'ok';
            } else {
                $this->status = 'error';
            }
            $response = [
                'data' => $data,
                'item' => $entity
            ];
            $this->set('response', $response);
            $this->set('_serialize', ['response']);
            return;
        }
        $table_p = Inflector::underscore($model);
        $table_s = Inflector::singularize($table_p);
        $human_p = Inflector::humanize($table_p);
        $human_s = Inflector::singularize($human_p);
        $name = [
            'singular' => [
                'table' => $table_s,
                'human' => $human_s
            ],
            'plural' => [
                'table' => $table_p,
                'human' => $human_p
            ],
            'model' => $model
        ];
        
        $info = [
            'name' => [
                'singular' => [
                    'table' => $table_s,
                    'human' => $human_s
                ],
                'plural' => [
                    'table' => $table_p,
                    'human' => $human_p
                ],
                'model' => $model
            ],
            'fields' => $fields
        ];
        // $this->set(compact('model', 'fields', 'name', 'info'));
        // $this->set('_serialize', ['model', 'fields', 'name', 'info']);
        $this->set(compact('info'));
        $this->set('_serialize', ['info']);
        if (array_key_exists('modal', $options) && $options['modal']) {
            $this->render('modal');
        } else {
            $this->render('form');
        }
    }
    
    public function form_submit() {
        $this->viewClass = 'Json';
        $model = $this->request->query['model'];
        if ($this->request->is('post')) {
            $this->loadModel($model);
            $item = $this->$model->newEntity($this->request->data);
        }
    }
}