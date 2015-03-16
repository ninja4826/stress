<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="manufacturerModalLabel">Create a Manufacturer</h4>
        </div>
        <div class="modal-body">
            <div id="manufacturer-alert"></div>
            <p>The manufacturer you specified could not be found.</p>
            <p>If this was a mistake, please correct the mistake and try again. Otherwise, please create a new Manufacturer.</p>
            <?= $this->Form->create(null, ['class' => 'manufacturer-form']); ?>
            <fieldset>
                <legend><?= __('Create a Manufacturer') ?></legend>
                <?php
                    echo $this->Form->input('manufacturer_name', ['type' => 'text']);
                    echo $this->Form->input('active', ['type' => 'checkbox', 'label' => 'Active', 'id' => 'manufacturer-active', 'default' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn-success form-submit-btn', 'id' => 'manufacturer-form-submit']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>
<script>
    $('#manufacturer-form-submit').click(function( event ) {
        event.preventDefault();
        
        var manufacturer_active = (($('#manufacturer-active').is(':checked')) ? 1 : 0);
        var manufacturer_name = $('#manufacturer-name').val();
        
        $.post('/api/add_modal?model=Manufacturers', {
            'manufacturer_name': manufacturer_name,
            'active': manufacturer_active
        }).done(function( data ) {
            if (data['response']['status'] == "error") {
                var alert_text = "The Manufacturer could not be saved. Please try again.";
                $('#manufacturer-alert').append('<div class="alert alert-danger" role="alert">' + alert_text + '</div>');
            } else {
                $('#manufacturer-id').val(manufacturer_name);
                $('#manufacturerModal').modal('hide');
                keys['Manufacturers'][manufacturer_name] = Number(data['response']['item']['id']);
            }
        });
    });
</script>