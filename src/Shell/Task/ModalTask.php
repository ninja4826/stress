<?php
namespace App\Shell\Task;

use Bake\Shell\Task\SimpleBakeTask;

class ModalTask extends SimpleBakeTask {
    public $pathFragment = 'Template/Element/modals/';
    
    public function name() {
        return 'modal';
    }
    
    public function fileName($name) {
        return $name . '_modal.ctp';
    }
    
    public function template() {
        return 'modal';
    }
}