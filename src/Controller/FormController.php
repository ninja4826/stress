<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Utility\Inflector;
use Cake\View\CellTrait;

class FormController extends AppController {
    
    use CellTrait;
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Csrf', [
            'secure' => false
        ]);
        $this->loadComponent('API');
    }
    
    public function form($model) {
        Log::write('debug', 'MODEL: '.$model);
        $this->loadModel($model);
        if (is_null($this->$model)) {
            return;
        }
        $alter = [];
        if (array_key_exists('alter', $this->request->query)) {
            $alter = $this->request->query['alter'];
        }
        $modal = false;
        if (array_key_exists('modal', $this->request->query) && $this->request->query['modal']) {
            $modal = true;
            $this->layout = 'empty';
        }
        // $cell = $this->cell('Form', ['model' => $model, 'alter' => $alter, 'modal' => $modal]);
        $cell = ['model' => $model, 'alter' => $alter, 'modal' => $modal];
        $this->set('cell', $cell);
        $this->render('/Element/form');
    }
}