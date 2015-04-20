<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Inflector;
use Cake\Controller\ComponentRegistry;

/**
 * Form cell
 */
class FormCell extends Cell
{
    
    private $_components = null;

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    private function components() {
        if ($this->_components === null) {
            $this->_components = new ComponentRegistry();
        }
        return $this->_components;
    }
    
    private function loadComponent($name, array $config = []) {
        $this->$name = $this->components()->load($name, $config);
        return $this->$name;
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($model, array $alter = [], $modal = false)
    {
        $this->loadComponent('API');
        $info = $this->API->get_info($model, $alter);
        $this->set(compact('info', 'modal'));
    }
}
