<?php
    if (isset($cell)) {
        echo debug($cell);
        echo $this->element('form', ['cell' => $cell]);
    }
?>