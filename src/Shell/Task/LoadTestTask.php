<?php
namespace App\Shell\Task;

use Cake\Console\Shell;

class LoadTestTask extends Shell {
    
    private $chars = 'abcdefghijklmnopqrstuvwxyz';
    
    public function initialize() {
        parent::initialize();
    }
    
    public function main() {
        ini_set('memory_limit', '512M');
    }
    
    public function start($model, $display_field, $iterations) {
        $this->display_field = $display_field;
        $this->stop = $iterations;
        $this->strings = $this->randomString();
        $this->loadModel($model);
        $this->model = $model;
        
        $this->fields = $this->$model->getFields();
        $this->randomTest($model);
    }
    
    public function randomTest() {
        $model = $this->model;
        for ($r = 0; $r < $this->stop; $r++) {
            $entity_ = [];
            foreach($this->fields as $field => $data) {
                if ((array_key_exists('check', $data) && $data['check']) || $field == $this->display_field) {
                    $entity_[$data['field_name']] = $this->strings[$r];
                    $this->out('CHECK FOUND');
                    $this->out($field);
                } elseif (array_key_exists('assoc', $data) && ($data['assoc'] != false)) {
                    $entity_[$data['assoc']['key']] = 1;
                    $this->out('ASSOC FOUND');
                    $this->out($field);
                } elseif ($data['type'] == 'text') {
                    $entity_[$data['field_name']] = 'blah';
                    $this->out('TEXT FOUND');
                    $this->out($field);
                } elseif ($data['type'] == 'checkbox') {
                    $entity_[$data['field_name']] = 1;
                    $this->out('CHECKBOX FOUND');
                    $this->out($field);
                } elseif ($data['type'] == 'number') {
                    $entity_[$data['field_name']] = 5;
                    $this->out('NUMBER FOUND');
                    $this->out($field);
                }
            }
            $this->out('ENTITY');
            $this->out(print_r($entity_));
            // return;
            $entity = $this->$model->newEntity($entity_);
            if ($this->$model->save($entity)) {
                $this->out('saved');
                $this->out('Made '.$model.' #: '.$entity->id);
		        $percent = ($r / $this->stop) * 100;
		        $this->out('#'.$r.' out of '.$this->stop);
                $this->out('Done: '.$percent.'%');
                $this->out('');
                
            } else {
                $this->out('Something went wrong...');
                break;
            }
        }
    }
    
    public function randomString() {
        $str_arr = [];
        for ($i = 0; $i < $this->stop; $i++) {
            $existing = true;
            while ($existing) {
                $str = '';
                for ($c = 0; $c < 200; $c++) {
                    $str .= $this->chars[rand(0, strlen($this->chars) - 1)];
                }
                if (!in_array($str, $str_arr)) {
                    $str_arr[] = $str;
                    $this->out('Iteration: '.$i);
                    $this->out('String: '.$str);
                    $existing = false;
                } else {
                    $this->out('Shit.');
                }
            }
        }
        return $str_arr;
    }
}