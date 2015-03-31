<?php
$modal = <<<MODAL
<div class="modal fade" id="{{model}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{model}}ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal title" id="{{model}}ModalLabel">Create a {{model_label}}</h4>
            </div>
            <div class="modal-body">
                <div id="{{model}}-alert></div>
                <p>The {{model_label}} you specified could not be found.</p>
                <p>If this was a mistake, please correct the mistake and try again. Otherwise, please create a new {{model_label}}.</p>
                
</div>
MODAL;
?>