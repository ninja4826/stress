<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Part'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['controller' => 'Manufacturers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manufacturer'), ['controller' => 'Manufacturers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['controller' => 'CostCenters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cost Center'), ['controller' => 'CostCenters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="parts form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($part, ['class' => 'part-form']); ?>
    <fieldset>
        <legend><?= __('Add Part') ?></legend>
        <?php
            echo $this->Form->input('part_num');
            echo $this->Form->input('description');
            echo $this->Form->input('amt_on_hand');
            echo $this->Form->input('active');
            echo $this->Form->input('location_name', ['type' => 'text', 'required' => true]);
            echo $this->Form->input('manufacturer_id', ['options' => $manufacturers]);
            echo $this->Form->input('category_id', ['options' => $categories]);
            echo $this->Form->input('cc_id', ['options' => $costCenters, 'label' => 'Cost Center']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success form-submit-btn']) ?>
    <?= $this->Form->end() ?>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmModalLabel">Confirm Quantity Addition</h4>
            </div>
            <div class="modal-body">
                <p>A part with that part number has already been entered and currently has a quantity of <strong id="current-quantity-placeholder"></strong>.</p>
                <p>If you continue, <strong id="new-quantity-placeholder"></strong> will be added to the part "<strong id="part-num-placeholder"></strong>" for a total of <strong id="total-quantity-placeholder"></strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="confirmModal-submit">Continue anyways</button>
                <button type="button" class="btn btn-danger" id="confirmModal-cancel">Cancel part registration</button>
            </div>
        </div>
    </div>
</div>

<!-- Script for functionality -->
<script>
    $(document).ready(function() {
        var json = {};
        
        $(".form-group.required > input").attr('rel', 'popover');
        $(".form-group.required > input").attr('data-content', 'This field cannot be left blank.');
        $(".form-group.required > input").attr('data-placement', 'bottom');
        
        var model_hash = {
            Parts: ['amt_on_hand'],
            Categories: [],
            Manufacturers: [],
            CostCenters: []
        };
        
        var json_str = '../api/get_all.json?models=' + JSON.stringify(model_hash);
        
        
        
        json_str += JSON.stringify(model_hash);
        
        $.getJSON("../api/get_all.json", function( data ) { json = data.parts; });
        
        $(".form-submit-btn").click(function( event ) {
            
            $("#part-num").popover('hide');
            $("#amt-on-hand").popover('hide');
            $("#description").popover('hide');
            $("#location-name").popover('hide');
            
            event.preventDefault();
            
            var part_num_val = $("#part-num").val();
            var new_quantity_val = $("#amt-on-hand").val();
            var description_val = $("#description").val();
            var location_val = $("#location-name").val();
            
            if (!part_num_val) {
                $("#part-num").popover('show');
            }
            
            if (!new_quantity_val) {
                $("#amt-on-hand").popover('show');
                return;
            }
            
            // if ($.inArray($('#part-num').val(), json) >= 0)
            if (part_num_val in json)
            {
                
                $("#current-quantity-placeholder").text(String(json[part_num_val]));
                $("#new-quantity-placeholder").text(new_quantity_val)
                $("#part-num-placeholder").text(part_num_val)
                $("#total-quantity-placeholder").text(String(Number(new_quantity_val) + json[part_num_val]));
                
                $("#confirmModal").modal('show');
                
                $("#confirmModal-submit").click(function (event) {
                    $(".part-form").submit();
                });
                
                $("#confirmModal-cancel").click(function (event) {
                    window.location = "<?= $referer ?>"
                });
            } else {
                if (!description_val) {
                    $("#description").popover('show');
                }
                if (!location_val) {
                    $("#location-name").popover('show');
                    return;
                }
                $(".part-form").submit();
            }
        });
    });
</script>