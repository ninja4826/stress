<?php
namespace App\View\Widget;

use Cake\View\Widget\WidgetInterface;
use Cake\View\Form\ContextInterface;
use Cake\Log\Log;

class TestWidget implements WidgetInterface {
    protected $_templates;
    
    public function __construct($templates) {
        // Log::write('debug', 'CONSTRUCT TEMPLATES');
        // Log::write('debug', $templates);
        $this->_templates = $templates;
    }
    
    public function render(array $data, ContextInterface $context) {
        $data += [
            'name' => '',
        ];
        // Log::write('debug', 'CONTEXT');
        // Log::write('debug', $context);
        // Log::write('debug', 'RENDER DATA');
        // Log::write('debug', $data);
        $formatted = $this->_templates->format('test', [
            'name' => $data['name'],
            'attrs' => $this->_templates->formatAttributes($data, ['name'])
        ]);
        // Log::write('debug', 'FORMATTED');
        // Log::write('debug', $formatted);
        return $formatted;
    }
    
    public function secureFields(array $data) {
        // Log::write('debug', 'SECURE DATA');
        // Log::write('debug', $data);
        return [$data['name']];
    }
}