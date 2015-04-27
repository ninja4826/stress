<?php
    if (isset($cell)) {
        $this->Html->css([
            'bootstrap-datetimepicker.min'
        ], ['block' => true]);
        $this->Html->script([
            'typeahead.bundle.min',
            'form',
            'moment',
            'bootstrap-datetimepicker.min'
        ], ['block' => true]);
        echo $this->cell('Form', $cell);
    } else {
        echo '';
    }
?>