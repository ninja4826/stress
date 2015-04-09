<?php
namespace App\Shell\Task;

use Bake\Shell\Task\SimpleBakeTask;

class ModalFormTask extends SimpleBakeTask {
    public $pathFragment = 'Template/Element/modals/forms/';
    
    public function name() {
        return 'modal_form';
    }
    
    public function fileName($name) {
        return $name . '_modal_form.ctp';
    }
    
    public function template() {
        return 'modal_form';
    }
}