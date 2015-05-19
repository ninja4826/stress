<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Controller\ComponentRegistry;
use Cake\Log\Log;
use Cake\Routing\Router;

/**
 * Table cell
 */
class TableCell extends Cell
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
    public function display($model, $actionType)
    {
        
    }
    
    public function index($model, $alterations)
    {
        $this->loadComponent('API');
        $info = $this->API->get_info($model, $alterations, false);
        $info['results'] = $this->API->search([$model => []]);
        
        $fields = $info['fields'];
        
        foreach($fields as $field_name => $field) {
            // if (array_key_exists('assoc', $field) && array_key_exists('type', $field['assoc']) && $field['assoc']['type'] == 'belongsToMany') {
            //     unset($info['fields'][$field_name]);
            // }
            if (array_key_exists('assoc', $field)) {
                if (array_key_exists('type', $field['assoc']) && $field['assoc']['type'] == 'belongsToMany') {
                    unset($info['fields'][$field_name]);
                    
                } elseif (array_key_exists('display_field', $field) && $field['display_field']) {
                    $info['fields'][$field_name]['url'] = Router::url([
                        'controller' => $model,
                        'action' => 'view'
                    ]);
                } else {
                    $info['fields'][$field_name]['assoc']['url'] = Router::url([
                        'controller' => $field['assoc']['model'],
                        'action' => 'view',
                    ]);
                }
            } elseif (array_key_exists('display_field', $field) && $field['display_field']) {
                $info['fields'][$field_name]['url'] = Router::url([
                    'controller' => $model,
                    'action' => 'view'
                ]);
            }
        }
        
        $this->set(compact('info'));
    }
}
