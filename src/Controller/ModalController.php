<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class ModalController extends AppController {
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    public function form() {
        $this->layout = 'empty';
        $options = $this->request->query;
        $model = $options['model'];
        $this->loadModel($model);
        $fields = $this->$model->fields;
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
        $this->set(compact('model', 'fields'));
    }
}