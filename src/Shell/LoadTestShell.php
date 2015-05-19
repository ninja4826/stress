<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Blah shell command.
 */
class LoadTestShell extends Shell
{
    
    public $tasks = ['Progressbar'];
    
    private $chars = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() {
        $model = $this->args[0];
        $display_field = $this->args[1];
        $iter = $this->args[2];
        if (!($model && $display_field && $iter)) {
            $this->out('Cannot continue');
            return;
        }
        // $this->LoadTest->start($model, $display_field, $iter);
        $this->Progressbar->init(intval($this->args[2]), $model.': ');
        
        $this->start($model, $display_field, $iter);
    }
    
    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser
            ->addArgument('model', [
                'help' => 'The model to use.',
                'required' => true
            ])->addArgument('display_field', [
                'help' => 'The field to use as a unique identifier.',
                'required' => true
            ])->addArgument('iterations', [
                'help' => 'The number of iterations to run.',
                'required' => true
            ])->addOption('chars', [
                'help' => 'The number of characters to use as a random identifier.',
                'default' => 100,
                'short' => 'c'
            ]);
        return $parser;
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
                } elseif (array_key_exists('assoc', $data) && ($data['assoc'] != false)) {
                    if (array_key_exists('type', $data['assoc']) && ($data['assoc']['type'] == 'belongsToMany')) {
                        $entity[$field] = ['_ids' => [1]];
                    } else {
                        $entity_[$data['assoc']['key']] = 1;
                    }
                } elseif ($data['type'] == 'text') {
                    $entity_[$data['field_name']] = 'blah';
                } elseif ($data['type'] == 'checkbox') {
                    $entity_[$data['field_name']] = 1;
                } elseif ($data['type'] == 'number') {
                    $entity_[$data['field_name']] = 5;
                }
            }
            // return;
            $entity = $this->$model->newEntity($entity_);
            if ($this->$model->save($entity)) {
                $this->Progressbar->add();
            } else {
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
                for ($c = 0; $c < $this->params['chars']; $c++) {
                    $str .= $this->chars[rand(0, strlen($this->chars) - 1)];
                }
                if (!in_array($str, $str_arr)) {
                    $str_arr[] = $str;
                    $existing = false;
                }
            }
        }
        return $str_arr;
    }
}
