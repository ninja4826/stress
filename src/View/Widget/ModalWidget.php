<?php
namespace App\View\Widget;

use Cake\View\Widget\WidgetInterface;
use Cake\View\Form\ContextInterface;
use Cake\Log\Log;

class ModalWidget implements WidgetInterface {
    protected $_templates;
    
    public function __construct($templates) {
        $this->_templates = $templates;
    }
    
    public function render(array $data, ContextInterface $context) {
        
    }
    public function secureFields(array $data) {
        return [];
    }
}