<?php
    if (isset($cell)) {
        $this->Html->css([
            'bootstrap-datetimepicker.min'
        ], ['block' => true]);
        $this->Html->script([
            'typeahead.bundle.min',
            'moment',
            'bootstrap-datetimepicker.min',
            'underscore-min',
            'form',
        ], ['block' => true]);
        echo $this->cell('Form', $cell);
    } else {
        echo '';
    }
?>