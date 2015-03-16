<?php $this->prepend('script', $this->Html->script('typeahead.bundle')); ?>

<style>
    .twitter-typeahead {
        width: 100%;
    }
    .tt-dropdown-menu {
        width: 100%;
    }
    .tt-hint {
        width: 100%;
    }
    .tt-dropdown-menu{
        display: none !important;
    }
</style>

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
            echo $this->Form->input('part_num', ['default' => 'SN74S74N2']);
            echo $this->Form->input('description', ['default' => 'test']);
            echo $this->Form->input('amt_on_hand', ['default' => 2]);
            echo $this->Form->input('active');
            echo $this->Form->input('location_name', ['type' => 'text', 'required' => true, 'default' => 'G1C2']);
            // echo $this->Form->input('manufacturer_id', ['options' => $manufacturers]);
            // echo $this->Form->input('category_id', ['options' => $categories]);
            // echo $this->Form->input('cc_id', ['options' => $costCenters, 'label' => 'Cost Center']);
            echo $this->Form->input('manufacturer_id', ['type' => 'text', 'required' => true, 'default' => 'blah']);
            echo $this->Form->input('category_id', ['type' => 'text', 'required' => true, 'default' => 'flip']);
            echo $this->Form->input('cc_id', ['type' => 'text', 'required' => true, 'label' => 'Cost Center', 'default' => 'test center']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success form-submit-btn', 'id' => 'parts-form-submit']) ?>
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
<script>
    var keys = {};
</script>
<!-- Manufacturer creation modal -->
<div class="modal fade" id="manufacturerModal" tabindex="-1" role="dialog" aria-labelledby="manufacturerModalLabel" aria-hidden="true"></div>
<!-- Category creation modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true"></div>
<!-- CostCenter creation modal -->
<div class="modal fade" id="cost_centerModal" tabindex="-1" role="dialog" aria-labelledby="cost_centerModalLabel" aria-hidden="true"></div>

<!-- Script for functionality -->
<script>
    $(document).ready(function() {
        $("input[required='required'").attr('rel', 'popover');
        $("input[required='required'").attr('data-content', 'This field cannot be left blank.');
        $("input[required='required'").attr('data-placement', 'bottom');
        
        $("input[required='required'")
        
        var model_hash = {
            Parts: {
                'fields': ['amt_on_hand']
            },
            Categories: {},
            Manufacturers: {},
            CostCenters: {},
        };
        
        var json_str = '../api/search.json?q=' + JSON.stringify(model_hash);
        
        console.log(json_str);
        
        var results = {};
        keys = {};
        var parts = {};
        
        $.getJSON(json_str, function( response ) {
            console.log('Full response object');
            console.log(response);
            results = response['response'];
            console.log('Filtered response object');
            console.log(results);
            for (var part_i in results['Parts']) {
                var part = results['Parts'][part_i];
                
                parts[part['part_num']] = part['amt_on_hand'];
            }
            console.log('Parts');
            console.log(parts);
            var types = {};
            for (var model_str in results) {
                var model = results[model_str];
                types[model_str] = [];
                keys[model_str] = {};
                for (var item_i in model) {
                    var item = model[item_i];
                    types[model_str].push(item['display_name']);
                    keys[model_str][item['display_name']] = item['id'];
                }
            }
            console.log('Response filtered into their designated types and what-have you.');
            console.log(types);
            console.log('types JSON');
            console.log(JSON.stringify(types));
            
            console.log('Keys');
            console.log(keys);
            
            
            var substringMatcher = function(strs) {
              return function findMatches(q, cb) {
                var matches, substrRegex;
             
                // an array that will be populated with substring matches
                matches = [];
             
                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');
             
                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                  if (substrRegex.test(str)) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({ value: str });
                  }
                });
             
                cb(matches);
              };
            };
            
            $('#part-num').typeahead(
                {highlight: true, minLength: 1},
                {name: 'parts', source: substringMatcher(types['Parts'])}
            );
            $('#manufacturer-id').typeahead(
                {highlight: true, minLength: 1},
                {name: 'manufacturers', source: substringMatcher(types['Manufacturers'])}
            );
            $('#category-id').typeahead(
                {highlight: true, minLength: 1},
                {name: 'categories', source: substringMatcher(types['Categories'])}
            );
            $('#cc-id').typeahead(
                {highlight: true, minLength: 1},
                {name: 'cost_centers', source: substringMatcher(types['CostCenters'])}
            );
            
            $('#part-num').focusout(function() {
                
            });
        });
        
        $('#parts-form-submit').click(function( event ) {
            $('#part-num').popover('hide');
            $('#amt-on-hand').popover('hide');
            $('#description').popover('hide');
            $('#location-name').popover('hide');
            
            event.preventDefault();
            
            var part_num_val = $('#part-num').val();
            var new_quantity_val = $('#amt-on-hand').val();
            var description_val = $('#description').val();
            var location_val = $('#location-name').val();
            
            var manufacturer_val = $('#manufacturer-id').val();
            var category_val = $('#category-id').val();
            var cost_center_val = $('#cc-id').val();
            
            if (!part_num_val) {
                $('#part-num').popover('show');
            }
            if (!new_quantity_val) {
                $('#amt-on-hand').popover('show');
            }
            
            if (!part_num_val || !new_quantity_val) {
                return;
            }
            
            if (part_num_val in parts) {
                $("#current-quantity-placeholder").text(String(parts[part_num_val]));
                $("#new-quantity-placeholder").text(new_quantity_val)
                $("#part-num-placeholder").text(part_num_val)
                $("#total-quantity-placeholder").text(String(Number(new_quantity_val) + parts[part_num_val]));
                
                $("#confirmModal").modal('show');
                
                $("#confirmModal-submit").click(function (event) {
                    $(".part-form").submit();
                });
                
                $("#confirmModal-cancel").click(function (event) {
                    window.location = "<?= $referer ?>"
                });
            } else {
                if (!description_val) {
                    $('#description').popover('show');
                }
                if (!location_val) {
                    $('#location-name').popover('show');
                }
                if (!manufacturer_val) {
                    $('#manufacturer-id').popover('show');
                }
                if (!category_val) {
                    $('#category-id').popover('show');
                }
                if (!cost_center_val) {
                    $('#cc-id').popover('show');
                }
                if (!description_val || !location_val || !manufacturer_val || !category_val || !cost_center_val) {
                    return;
                }
                
                $('#manufacturerModal').on('hidden.bs.modal', function() {
                    if (!(category_val in keys['Categories'])) {
                        $('#categoryModal').load('/api/add_modal?model=Categories', function() {
                            $('#categoryModal').modal('show');
                        });
                    } else {
                        $('#categoryModal').trigger('hidden.bs.modal');
                    }
                });
                
                $('#categoryModal').on('hidden.bs.modal', function() {
                    if (!(cost_center_val in keys['CostCenters'])) {
                        $('#cost_centerModal').load('/api/add_modal?model=CostCenters', function() {
                            $('#cost_centerModal').modal('show');
                        });
                    } else {
                        $('#cost_centerModal').trigger('hidden.bs.modal');
                    }
                });
                
                $('#cost_centerModal').on('hidden.bs.modal', function() {
                    var manufacturer_id = keys['Manufacturers'][manufacturer_val];
                    var category_id = keys['Categories'][category_val];
                    var cost_center_id = keys['CostCenters'][cost_center_val];
                    console.log(keys);
                    $.post('/parts/add', {
                        'part_num': part_num_val,
                        'description': description_val,
                        'amt_on_hand': new_quantity_val,
                        'active': (($('#active').is(':checked')) ? 1 : 0),
                        'location_name': location_val,
                        'manufacturer_id': manufacturer_id,
                        'category_id': category_id,
                        'cc_id': cost_center_id
                    }).done(function( data ) {
                        window.location = '/';
                    });
                });
                
                if (!(manufacturer_val in keys['Manufacturers'])) {
                    $('#manufacturerModal').load('/api/add_modal?model=Manufacturers', function() {
                        $('#manufacturerModal').modal('show');
                    });
                } else {
                    $('#manufacturerModal').trigger('hidden.bs.modal');
                }
                
                
            }
        });
    });
</script>