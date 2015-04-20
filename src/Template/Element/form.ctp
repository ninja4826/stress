<?php
    if (isset($cell)) {
        echo debug($cell);
        $this->Html->script(['typeahead.bundle.min', 'form'], ['block' => true]);
        echo $cell;
    } else {
        echo '';
    }
?>