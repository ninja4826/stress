<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use cake\Log\Log;
use Cake\Utility\Inflector;

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
        }
        $response['status'] = 'ok';
        return $response;
    }
    
    private function loadModel($model) {
        $table = TableRegistry::get($model);
        if (explode('\\', get_class($table))[-1] = 'Table') {
            $this->$model = null;
        } else {
            $this->$model = $table;
        }
    }
    
    public function get_info($model, array $alterations = [], $search = true) {
        $this->$model = TableRegistry::get($model);
        if (is_null($this->$model)) {
            return [];
        }
        $fields = $this->$model->getFields();
        
        $q = [];
        $search_arr = [
            $model => [
                'fields' => []
            ]
        ];
        
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
            'fields' => $fields
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
        return $info;
    }
    
    public function field_merge(array $first, array $second) {
        foreach ($second as $key => $val) {
            if (gettype($val) == 'array') {
                $first[$key] = $this->field_merge($first[$key], $val);
            } else {
                $first[$key] = $val;
            }
        }
        return $first;
    }
}