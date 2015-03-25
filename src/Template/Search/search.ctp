<?php
$form_fields = [
    'parts' => [
        'fields' => [
            'part_num' => [
                'label' => 'Part Number',
                'type' => 'string'
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'string'
            ],
            'amt_on_hand' => [
                'label' => 'Amount on Hand',
                'type' => 'integer'
            ],
            'active' => [
                'label' => 'Active',
                'type' => 'boolean'
            ],
        ],
        'name' => 'part',
    ],
    'categories' => [
        'fields' => [
            'category_name' => [
                'label' => 'Name',
                'type' => 'string'
            ]
        ],
        'name' => 'category'
    ],
    'cost_centers' => [
        'fields' => [
            'e_code' => [
                'label' => 'E-Code',
                'type' => 'string'
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'string'
            ],
            'active' => [
                'label' => 'Active',
                'type' => 'boolean'
            ],
            'default_value' => [
                'label' => 'Default',
                'type' => 'string'
            ],
            'project_number' => [
                'label' => 'Project Number',
                'type' => 'string'
            ]
        ],
        'name' => 'cost_center'
    ],
    'manufacturers' => [
        'fields' => [
            'manufacturer_name' => [
                'label' => 'Name',
                'type' => 'string'
            ],
            'active' => [
                'label' => 'Active',
                'type' => 'boolean'
            ]
        ],
        'name' => 'manufacturer'
    ]
];

$options = [
    'string' => [
        'like',
        '=='
    ],
    'integer' => [
        '==',
        '<',
        '>',
        '<=',
        '>='
    ],
    'boolean' => [
        '==',
        '!='
    ]
];
?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default" id="search-panel">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-target="#collapse-search" href="#collapse-search">
                    Search
                </a>
            </h4>
        </div>
        <div id="collapse-search" class="panel-collapse collapse">
            <div class="panel-body">
                <form method="post" accept-charset="utf-8" id="search-form" action="#">
                    <div style="display:none;">
                        <input type="hidden" name="_method" value="POST">
                    </div>
                    <?php foreach($form_fields as $name => $form): ?>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default" id="<?=$name?>-panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-target="#collapse-<?=$name?>" href="#collapse-<?$name?>">
                                            <?= ucwords(str_replace("_", " ", $name)) ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-<?=$name?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="<?=$name?> form col-lg-10 col-md-9 columns">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-lg-9 clone-home">
                                                        <div class="input-group entry" id="<?=$name?>-input-0" table="<?=$name?>">
                                                            <span class="input-group-btn">
                                                                <select class="btn field-input">
                                                                    <?php $first_field = null; ?>
                                                                    <?php foreach($form['fields'] as $field => $props): ?>
                                                                        <?php
                                                                            if (is_null($first_field)) {
                                                                                $first_field = $props['type'];
                                                                            }
                                                                        ?>
                                                                        <option value="<?=$field?>"><?=$props['label']?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </span>
                                                            <span class="input-group-btn">
                                                                <span class="btn">is</span>
                                                            </span>
                                                            <span class="input-group-btn" id="operation-input-span">
                                                                <select class="btn operation-input">
                                                                    <?php foreach($options[$first_field] as $op): ?>
                                                                        <option value="<?=$op?>"><?=$op?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </span>
                                                            <input type="text" class="form-control query-input">
                                                            <span class="input-group-btn">
                                                                <!--<button class="btn btn-success btn-add" type="button">-->
                                                                <!--    <span class="glyphicon glyphicon-plus"></span>-->
                                                                <!--</button>-->
                                                                
                                                                <button type="button" class="btn btn-success btn-add" id="entry-button">
                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                </button>
                                                                <button type="button" class="btn btn-success dropdown-toggle" id="cond-dropdown" data-toggle="dropdown" aria-expanded="false">
                                                                    <span class="caret"></span>
                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="#" class="condition" cond="or">Convert to an OR condition</a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#" class="condition" cond="and">Convert to an AND condition</a></li>
                                                                </ul>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <button class="btn-success form-submit-btn btn" id="search-form-submit" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- HIDDEN CONDITION TEMPLATES -->
<p class="text-center" style="display:none;" id="or-clone"><em>OR</em></p>
<p class="text-center" style="display:none;" id="and-clone"><em>AND</em></p>

<!-- HIDDEN WELL TEMPLATES -->
<div class="well well-sm" style="display:none;" id="well-clone">
    <button type="button" class="close" id="well-close-button" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<script>
    $(document).ready(function() {
        var field_options = {
            'string': [
                'like',
                '=='
            ],
            'integer': [
                '==',
                '<',
                '>',
                '<=',
                '>='
            ],
            'boolean': [
                '==',
                '!='
            ]
        };
        
        var form_fields = $.parseJSON('<?= json_encode($form_fields) ?>');
        
        var field_inputs = {
            'parts': {},
            'categories': {},
            'cost_centers': {},
            'manufacturers': {}
        }
        
        $('.entry').each(function( index ) {
            var table = $(this).attr('table');
            var id = $(this).attr('id');
            field_inputs[table][id] = this;
        });
        console.log(field_inputs);
        // $(document).on('click', '.btn-add', function() {
        //     var table = $(this).parents('.entry').attr('table');
        //     var old_id_num = $(this).parents('.entry:first').attr('id').split('-')[2];
        //     var new_id = table + '-input-' + (parseInt(old_id_num, 10) + 1).toString();
        //     var controlForm = $("#search-form"),
        //         currentEntry = $(this).parents('.entry:first'),
        //         cloneEntry = $(currentEntry.clone().prop({ id: new_id })),
        //         newEntry = cloneEntry.appendTo($(this).parents(".clone-home"));
                
        //     newEntry.find('input').val('');
        //     $(this).removeClass('btn-add').addClass('btn-remove')
        //         .removeClass('btn-success').addClass('btn-danger')
        //         .html('<span class="glyphicon glyphicon-minus"></span>');
        //     field_inputs[table][new_id] = newEntry[0];
        //     console.log(field_inputs);
        // });
        
        $(document).on('click', '.btn-add', function() {
            var original = $(this).parents('.entry');
            var parent = original.parent();
            // var and_clone = $('#and-clone').clone().removeAttr('id');
            // and_clone.attr('under', original.attr('id')).appendTo(parent);
            
            var newEntry = createInputGroup( original, parent );
            // and_clone.show();
            // and_clone.attr('id', 'asdf');
        });
        
        $(document).on('click', '.btn-remove', function() {
            var entry = $(this).parents('.entry');
            var entry_id = entry.attr('id').toString();
            console.log(entry_id);
            var clone = $('[under="' + entry_id + '"]');
            console.log(clone);
            clone.remove();
            entry.remove();
            
            return false;
        });
        
        $(document).on('change', '.field-input', function() {
            var opt = $(this).parent().siblings('#operation-input-span').find('.operation-input');
            opt.empty();
            var val = $(this).val();
            
            var name = $(this).parents('.entry').attr('table');
            var field_type = form_fields[name]['fields'][val]['type'];
            $.each(field_options[field_type], function(operation) {
                operation = field_options[field_type][operation];
                opt.append('<option value="' + operation + '">' + operation + '</option>');
            });
        });
        
        $('#search-form').submit(function( event ) {
            event.preventDefault();
            var filters = {};
            
            $('.entry').each(function() {
                
            });
        });
        
        $(document).on('click', '.condition', function() {
            var well = $('#well-clone').clone();
            var entry = $(this).parents('.entry');
            var entry_id = entry.attr('id');
            entry.before(well);
            entry.appendTo(well);
            
            var newEntry = createInputGroup(
                entry,
                ($(this).attr('cond') === "or")
            );
            entry.find('#entry-button, #cond-dropdown, .dropdown-menu').hide();
            well.removeAttr('id');
            well.show();
        });
        
        $(document).on('click', '#well-close-button', function() {
            var parent = $(this).parent();
            var grandparent = parent.parent();
            
            console.log('Parent');
            console.log(parent);
            console.log('Grandparent');
            console.log(grandparent);
            
            var template_entry = parent.find('.entry:first');
            var template_id = parseInt(template_entry.attr('id').split('-')[2]);
            console.log('Template');
            console.log(template_entry);
            console.log('Template ID');
            console.log(template_id);
            
            var first_entry = grandparent.find('> .entry:first');
            var first_id = undefined;
            
            if (first_entry.length > 0) {
                first_id = parseInt(first_entry.attr('id').split('-')[2]);
            }
            console.log('First');
            console.log(first_entry);
            console.log('First ID');
            console.log(first_id);
            if (typeof first_id === 'undefined' || first_id >= template_id) {
                template_entry.prependTo(grandparent);
            } else {
                var child = grandparent.children('.entry').each(function() {
                    var child_id = parseInt($(this).attr('id').split('-')[2]);
                    console.log(child_id);
                    if (template_id < child_id) {
                        return {
                            entry: $(this),
                            id: child_id
                        }
                    }
                });
                if (template_id < child['id']) {
                    child['entry'].before(template_entry);
                    // DO SOMETHING TO CREATE AN ITALIC CONDITION STRING BETWEEN THE TEMPLATE AND THE FIRST
                } else {
                    template_entry.appendTo(grandparent);
                }
            }
            parent.remove();
        })
    });
    
    // function createInputGroup( original, parent ) {
    //     var table = original.parents('.entry').attr('table');
    //     var old_id_num = original.parents('.entry:first').attr('id').split('-')[2];
    //     var new_id = table + '-input-' + (parseInt(old_id_num, 10) + 1).toString();
    //     var controlForm = $('#search-form'),
    //         currentEntry = original.parents('.entry:first'),
    //         cloneEntry = $(currentEntry.clone().prop({ id: new_id })),
    //         newEntry = cloneEntry.appendTo(parent);
    //     newEntry.find('input').val('');
    //     original.removeClass('btn-add').addClass('btn-remove')
    //         .removeClass('btn-success').addClass('btn-danger')
    //         .html('<span class="glyphicon glyphicon-minus"></span>');
    //     return newEntry;
    // }
    
    function createInputGroup( entry, or_condition) {
        or_condition = typeof or_condition !== 'undefined' ? or_condition : false;
        var condition;
        if (or_condition) {
            condition = 'or';
        } else {
            condition = 'and';
        }
        
        var parent = entry.parent();
        
        var and_clone = $('#' + condition + '-clone').clone().removeAttr('id');
        and_clone.attr('under', entry.attr('id')).appendTo(parent);
        
        var table = entry.attr('table');
        var old_id_num = entry.attr('id').split('-')[2];
        var new_id = table + '-input-' + (parseInt(old_id_num, 10) + 1).toString();
        var controlForm = $('#search-form');
        var clone = entry.clone().prop({ id: new_id });
        var newEntry = clone.appendTo(parent);
        newEntry.find('input').val('');
        entry.find('#entry-button').removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
        and_clone.show();
        return newEntry;
    }
    
    function filterConditionals( filters ) {
        
    }
    
    function toTitlecase(str) {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    }
</script>