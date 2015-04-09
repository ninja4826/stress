<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Modal cell
 */
class ModalCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];
    
    private $status = [];

    /**
     * Default display method.
     *
     * @return void
     */
    
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    public function display(array $options = [])
    {
        
    }
    
    public function form($options) {
        $model = $options['model'];
        $this->loadModel($model);
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
        }
        $this->set(compact('model', 'fields'));
    }
}
