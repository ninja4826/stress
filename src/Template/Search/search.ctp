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
                                                                
                                                                <button type="button" class="btn btn-success btn-add">
                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                </button>
                                                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
            var original = $(this);
            var parent = original.parents('.clone-home');
            createInputGroup( original, parent );
        });
        
        $(document).on('click', '.btn-remove', function() {
            var entry = $(this).parents('.entry:first');
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
                // FINISH ITERATION THROUGH SINGULAR AND CONDITIONAL ENTRIES, ADDING TO REQUEST AS OUTLINED IN query_format.json
            });
        });
        
        $(document).on('click', '.condition', function() {
            var well = '<div class="well well-sm" style="display:none;" id="move-here"></div>';
            var entry = $(this).parents('.entry');
            var entry_id = entry.attr('id');
            entry.before(well);
            var well_dom = $('#move-here');
            entry.appendTo(well_dom);
            entry.after('<p class="text-center"><em>OR</em></p>');
            // CREATE SECOND ITEM HERE
            well_dom.attr('id', '');
            well_dom.show();
        });
    });
    
    function createInputGroup( original, parent ) {
        var table = original.parents('.entry').attr('table');
        var old_id_num = original.parents('.entry:first').attr('id').split('-')[2];
        var new_id = table + '-input-' + (parseInt(old_id_num, 10) + 1).toString();
        
        var controlForm = $('#search-form'),
            currentEntry = original.parents('.entry:first'),
            cloneEntry = $(currentEntry.clone().prop({ id: new_id })),
            newEntry = cloneEntry.appendTo(parent);
        
        newEntry.find('input').val('');
        
        original.removeClass('btn-add').addclass('btn-remove')
            .removeClass('btn-success').addclass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
        return newEntry;
    }
    
    function toTitlecase(str) {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    }
</script>