<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="cost_centerModalLabel">Create a new Cost Center</h4>
        </div>
        <div class="modal-body">
            <div id="cost_center-alert"></div>
            <p>The cost center, "<strong id="specified_cost_center"></strong>" could not be found.</p>
            <p>If this was a mistake, please correct the mistake and try again. Otherwise, please create a new Cost Center.</p>
            <?= $this->Form->create(null, ['class' => 'cost_center-form']); ?>
            <fieldset>
                <legend><?= __('Create a Cost Center') ?></legend>
                <?php
                    echo $this->Form->input('e_code', ['type' => 'text', 'id' => 'cost_center-e_code']);
                    echo $this->Form->input('description', ['type' => 'text', 'id' => 'cost_center-description']);
                    echo $this->Form->input('active', ['type' => 'checkbox', 'label' => 'Active', 'id' => 'cost_center-active', 'default' => true]);
                    echo $this->Form->input('default_value', ['type' => 'text', 'id' => 'cost_center-default_value']);
                    echo $this->Form->input('project_number', ['type' => 'integer', 'id' => 'cost_center-project_number']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn-success form-submit-btn', 'id' => 'cost_center-form-submit']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<script>
    $('#cost_center-form-submit').click(function( event ) {
        event.preventDefault();
        
        var e_code = $('#cost_center-e_code').val();
        var description = $('#cost_center-description').val();
        var active = (($('#cost_center-active').is(':checked')) ? 1 : 0);
        var default_value = $('#cost_center-default_value').val();
        var project_number = $('#cost_center-project_number').val();
        
        $.post('/api/add_modal?model=CostCenters', {
            'e_code': e_code,
            'description': description,
            'active': active,
            'default_value': default_value,
            'project_number': project_number
        }).done(function( data ) {
            if (data['response']['status'] == "error") {
                var alert_text = "The Cost Center could not be saved. Please try again.";
                $('#cost_center-alert').append('<div class="alert alert-danger" role="alert">' + alert_text + '</div>');
            } else {
                $('#cc-id').val(e_code);
                $('#cost_centerModal').modal('hide');
            }
        });
    });
</script>