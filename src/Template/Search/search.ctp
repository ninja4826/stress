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
        'name' => 'part'
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
                <form method="post" accept-charset="utf-8" class="search-form" action="#">
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
                                                        <div class="input-group entry" id="<?=$name?>-input" table="<?=$name?>">
                                                            <span class="input-group-btn">
                                                                <select class="btn field-input">
                                                                    <?php foreach($form['fields'] as $field => $props): ?>
                                                                        <option value="<?=$field?>"><?=$props['label']?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </span>
                                                            <span class="input-group-btn">
                                                                <span class="btn">is</span>
                                                            </span>
                                                            <span class="input-group-btn" id="operation-input-span">
                                                                <select class="btn operation-input">
                                                                    <option></option>
                                                                </select>
                                                            </span>
                                                            <input type="text" class="form-control query-input">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-success btn-add" type="button">
                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                </button>
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
        console.log("Form Fields:");
        console.log(form_fields);
        console.log("Field Options");
        console.log(field_options);
        $(document).on('click', '.btn-add', function() {
            
            var controlForm = $(".search-form"),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo($(this).parents(".clone-home"));
                
            newEntry.find('input').val('');
            $(this).removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="glyphicon glyphicon-minus"></span>');
        });
        
        $(document).on('click', '.btn-remove', function() {
            $(this).parents('.entry:first').remove();
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
    });
</script>