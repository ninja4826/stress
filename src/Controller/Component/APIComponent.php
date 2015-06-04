<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use cake\Log\Log;
use Cake\Utility\Inflector;
use Cake\Routing\Router;

class APIComponent extends Component {
    protected $_defaultConfig = [];
    
    public static $formCSRF = '';
    
    public function search(array $q = []) {
        $response = [];
        if (empty($q)) {
            return ['status' => 'error'];
        }
        foreach ($q as $model => $options) {
            $this->$model = TableRegistry::get($model);
            
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
                $query = $this->$model->find('assoc', $options)->toArray();
            }
            $response[$model] = $query;
            // usort($response[$model], function($a, $b) {
            //     return strcasecmp($a['display_name'], $b['display_name']);
            // });
        }
        $response['status'] = 'ok';
        return $response;
    }
    
    private function loadModel($model) {
        $table = TableRegistry::get($model);
        if (explode('\\', get_class($table))[-1] == 'Table') {
            $this->$model = null;
        } else {
            $this->$model = $table;
        }
    }
    
    // public function get_info($model, array $alterations = [], $search = true) {
    public function get_info($model, $options = []) {
        $alterations = [];
        $search = true;
        $recursive = false;
        if (array_key_exists('recursive', $options)) {
            $recursive = $options['recursive'];
        }
        if (array_key_exists('alter', $options)) {
            $alterations = $options['alter'];
            if ($recursive && array_key_exists($model, $alterations)) {
                $alterations = $alterations[$model];
            }
        }
        if (array_key_exists('search', $options)) {
            $search = $options['search'];
        }
        $table = TableRegistry::get($model);
        if (is_null($table)) {
            return [];
        }
        $fields = $table->getFields();
        
        $q = [];
        $search_arr = [
            $model => [
                'fields' => []
            ]
        ];
        
        foreach($fields as $name => $field) {
            if (array_key_exists('assoc', $field)) {
                $fields[$name]['url'] = Router::url([
                    'controller' => 'Modular',
                    'action' => 'view',
                    $field['assoc']['model']
                ]);
            } else if (array_key_exists('display_field', $field) && $field['display_field']) {
                $fields[$name]['url'] = Router::url([
                    'controller' => 'Modular',
                    'action' => 'view',
                    $model
                ]);
            }
        }
        
        $fields_ = $this->field_merge($fields, $alterations);
        
        $table_p = Inflector::underscore($model);
        $table_s = Inflector::singularize($table_p);
        $human_p = Inflector::humanize($table_p);
        $human_s = Inflector::singularize($human_p);
        $html_p = str_replace('_', '-', strtolower($table_p));
        $html_s = str_replace('_', '-', strtolower($table_s));
        $info = [
            'name' => [
                'singular' => [
                    'table' => $table_s,
                    'human' => $human_s,
                    'html' => $html_s,
                ],
                'plural' => [
                    'table' => $table_p,
                    'human' => $human_p,
                    'html' => $html_p
                ],
                'model' => $model
            ],
            'fields' => $fields_
        ];
        
        if ($search) {
            foreach ($fields_ as $name => $field) {
                if (array_key_exists('check', $field) && $field['check']) {
                    $search_arr[$model]['fields'][] = $name;
                } elseif (array_key_exists('assoc', $field) && ($field['assoc'] != false)) {
                    if (!array_key_exists($field['assoc']['model'], $search_arr)) {
                        $search_arr[$field['assoc']['model']] = ['fields' => []];
                    }
                }
            }
            $info['search_results'] = $this->search($search_arr);
        }
        if ($recursive) {
            
            foreach($info['fields'] as $name => $field) {
                if (array_key_exists('assoc', $field)) {
                    $info['fields'][$name]['assoc']['info'] = $this->get_info($field['assoc']['model'], $options);
                }
            }
        }
        return $info;
    }
    
    public function field_merge(array $first, array $second) {
        foreach ($second as $key => $val) {
            if (gettype($val) == 'array') {
                if (array_key_exists($key, $first)) {
                    $first[$key] = $this->field_merge($first[$key], $val);
                } else {
                    $first[$key] = $val;
                }
            } else {
                $first[$key] = $val;
            }
        }
        return $first;
    }
}