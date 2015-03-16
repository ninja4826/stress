<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="categoryModalLabel">Create a Category</h4>
        </div>
        <div class="modal-body">
            <div id="category-alert"></div>
            <p>The category, "<strong id="specified_category"></strong>" could not be found.</p>
            <p>If this was a mistake, please correct the mistake and try again. Otherwise, please create a new Category.</p>
            <?= $this->Form->create(null, ['class' => 'category-form']); ?>
            <fieldset>
                <legend><?= __('Create a Category') ?></legend>
                <?php
                    echo $this->Form->input('category_name', ['type' => 'text']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn-success form-submit-btn', 'id' => 'category-form-submit']); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    $('#category-form-submit').click(function( event ) {
        event.preventDefault();
        
        var category_name = $('#category-name').val();
        
        $.post('/api/add_modal?model=Categories', {
            'category_name': category_name
        }).done(function( data ) {
            if (data['response']['status'] == "error") {
                var alert_text = "The Category could not be saved. Please try again.";
                $('#category-alert').append('<div class="alert alert-danger" role="alert">' + alert_text + '</div>');
            } else {
                $('#category-id').val(category_name);
                $('#categoryModal').modal('hide');
            }
        });
    });
</script>