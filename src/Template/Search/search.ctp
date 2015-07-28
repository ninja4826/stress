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
        '==',
        'regexp'
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

<style>
    .results-panel .panel-body {
        padding: 0;
    }
    .table .actions {
        text-align: right;
    }
    .panel-heading {
        cursor: pointer;
    }
</style>
<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('List Parts'), ['controller' => 'Parts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['controller' => 'CostCenters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['controller' => 'Manufacturers', 'action' => 'index']) ?></li>
    </ul>
</div>
<div class="search view col-lg-10 col-md-9 columns">
    <div class="row">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default" id="search-panel">
                <div class="panel-heading" data-toggle="collapse" data-target="#collapse-search" href="#collapse-search">
                    <h4 class="panel-title">
                        Search
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
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapse-<?=$name?>" href="#collapse-<?=$name?>">
                                            <h4 class="panel-title">
                                                <?= ucwords(str_replace("_", " ", $name)) ?>
                                            </h4>
                                        </div>
                                        <div id="collapse-<?=$name?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="<?=$name?> form col-lg-10 col-md-9 columns" style="width:100%;">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="clone-home" table="<?=$name?>" style="width:100%">
                                                                <div class="input-group entry" id="<?=$name?>-input-0">
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
                                                                    <span class="input-group-btn" id="operation-input-span">
                                                                        <select class="btn operation-input">
                                                                            <?php foreach($options[$first_field] as $op): ?>
                                                                                <option value="<?=$op?>"><?=$op?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </span>
                                                                    <input type="text" class="form-control query-input">
                                                                    <span class="input-group-btn" id="add-btn-group">
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
                                                                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                            <li><a href="#" class="condition or-cond" cond="or">Convert to an OR condition</a></li>
                                                                            <li class="divider"></li>
                                                                            <li><a href="#" class="condition and-cond" cond="and">Convert to an AND condition</a></li>
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
                            <button class="btn-success form-submit-btn btn" id="search-form-submit" type="button" data-loading-text="Searching..." autocomplete="off" rel="popover" data-content="Your search query is empty." data-placement="right">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="results"></div>
    </div>
</div>
<!-- HIDDEN CONDITION TEMPLATES -->
<p class="text-center cond-sep" style="display:none;" id="or-clone"><em>OR</em></p>
<p class="text-center cond-sep" style="display:none;" id="and-clone"><em>AND</em></p>

<!-- HIDDEN WELL TEMPLATES -->
<div class="well well-sm" style="display:none;" id="well-clone">
    <button type="button" class="close" id="well-close-button" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>

<script>
    $(document).ready(function() {
        $('.clone-home').prop('cond', 'and');
        $('.condition').each(function() {
            var cond = $(this);
            cond.prop('cond', cond.attr('cond')).removeAttr('cond');
        });
        
        $('.clone-home').each(function() {
            var table = $(this).attr('table');
            $(this).prop('table', table);
            $(this).removeAttr('table');
        });
        
        var field_options = {
            'string': [
                'like',
                '==',
                'regexp'
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
            var table = $(this).parents('.clone-home').prop('table');
            var id = $(this).attr('id');
            field_inputs[table][id] = this;
        });
        console.log(field_inputs);
        
        $(document).on('click', '.btn-add', function() {
            var original = $(this).parents('.entry');
            var parent = original.parent();
            
            // var input = createInput( original, parent );
            var input = createInput({
                entry: original,
                parent: parent
            });
            var newEntry = input['entry'];
            var cond = input['cond'];
            var or = newEntry.find('.or-cond').prop('cond', 'or');
            var and = newEntry.find('.and-cond').prop('cond', 'and');
            console.log(original.find('.and-cond').prop('cond'));
            console.log(newEntry.find('.and-cond').prop('cond'));
            cond.show();
        });
        
        $(document).on('click', '.btn-remove', function() {
            var entry = $(this).parents('.entry');
            var entry_id = entry.attr('id').toString();
            console.log(entry_id);
            var clone = entry.next('.cond-sep');
            console.log('ENTRY SEPARATOR');
            console.log(clone);
            console.log(clone.prop('under'));
            clone.remove();
            entry.remove();
            
            return false;
        });
        
        $(document).on('change', '.field-input', function() {
            var opt = $(this).parent().siblings('#operation-input-span').find('.operation-input');
            opt.empty();
            var val = $(this).val();
            
            var name = $(this).parents('.clone-home').prop('table');
            var field_type = form_fields[name]['fields'][val]['type'];
            $.each(field_options[field_type], function(operation) {
                operation = field_options[field_type][operation];
                opt.append('<option value="' + operation + '">' + operation + '</option>');
            });
        });
        
        // $('#search-form').submit(function( event ) {
        //     event.preventDefault();
        
        $(document).on('click', '.condition', function() {
            var condition = $(this).prop('cond');
            
            var well = $('#well-clone').clone().prop('cond', condition);
            var entry = $(this).parents('.entry');
            var cloner = entry.parent().children().last();
            console.log(cloner);
            var entry_id = entry.attr('id');
            entry.before(well);
            entry.appendTo(well);
            // var newEntry = createInput(
            //     cloner,
            //     ($(this).attr('cond') === "or")
            // );
            
            var newEntry = createInput({
                entry: cloner,
                parent: well
            });
            
            entry.find('#add-btn-group').hide();
            well.removeAttr('id');
            var cond = newEntry['cond'];
            // console.log(cond);
            
            if (cloner.is(':last-child')) {
                cloner.find('#entry-button').removeClass('btn-remove').addClass('btn-add')
                    .removeClass('btn-danger').addClass('btn-success')
                    .html('<span class="glyphicon glyphicon-plus"></span>');
            }
            
            cond.prop('under', entry.attr('id')).show();
            well.show();
        });
        
        $(document).on('click', '#well-close-button', function() {
            var parent = $(this).parent();
            var grandparent = parent.parent();
            
            console.log('Parent');
            console.log(parent);
            console.log('Grandparent');
            console.log(grandparent);
            
            var template_entry = parent.find('.entry:last').attr('id', parent.find('.entry:first').attr('id'));
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
                var under;
                grandparent.find('.cond-sep').each(function() {
                    if ($(this).prop('under') == template_entry.attr('id')) {
                        under = $(this);
                    }
                });
                console.log('UNDER');
                console.log(under);
                under.before(template_entry);
            }
            template_entry.find('#add-btn-group').show();
            parent.remove();
            if (!(template_entry.is(':last-child'))) {
                template_entry.find('#entry-button').removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }
        });
        
        $('.panel-heading').hover(function() {
            $(this).parents('.panel:first').removeClass('panel-default').addClass('panel-success');
        }, function() {
            $(this).parents('.panel:first').removeClass('panel-success').addClass('panel-default');
        });
        
        $(document).on('click', '#search-form-submit', function() {
            var arr = {
                filters: filterConditionals()
            };
            $('#search-form-submit').button('loading');
            if ($.isEmptyObject(arr['filters']) > 0) {
                $(this).popover('show');
                var button = $(this);
                setTimeout(function() {
                    button.popover('hide');
                }, 2000);
            }
            console.log('SENT DATA');
            console.log(arr);
            console.log('JSON REP');
            console.log(JSON.stringify(arr));
            getResults(arr);
            
            $('#search-form-submit').button('reset');
            $('#search-panel > .panel-heading').trigger('click');
        });
        
        var search_bar = JSON.parse('<?= json_encode($search_bar) ?>');
        console.log('SEARCH BAR');
        console.log(search_bar);
        if (search_bar['bar']) {
            console.log(search_bar['k']);
            getResults( search_bar['k'] );
        }
    });
    
    function getResults( data ) {
        // $('#results').load('/search', data, function() {
        $('#results').load('/search?q=' + JSON.stringify(data), function() {
            $('.results-panel').find('.panel-heading').trigger('click');
            $('#results-panel').find('.panel-heading').trigger('click');
            $('html, body').animate({ scrollTop: $('#results').offset().top }, 1000);
            $('.panel-heading').hover(function() {
                $(this).parents('.panel:first').removeClass('panel-default').addClass('panel-success');
            }, function() {
                $(this).parents('.panel:first').removeClass('panel-success').addClass('panel-default');
            });
        });
    }
    
    function createInput( options ) {
        var entry;
        if ('entry' in options) {
            entry = options['entry'];
        } else {
            return {
                entry: null,
                cond: null
            };
        }
        
        var parent = ('parent' in options ? options['parent'] : entry.parent());
        
        var condition = parent.prop('cond');
        
        var cond_clone = $('#' + condition + '-clone').clone().removeAttr('id');
        
        cond_clone.prop('under', entry.prop('id')).appendTo(parent);
        
        var table = entry.parents('.clone-home').prop('table');
        var old_id_num = entry.attr('id').split('-')[2];
        var new_id = table + '-input-' + (parseInt(old_id_num, 10) + 1).toString();
        var controlForm = $('#search-form');
        var clone = entry.clone().prop({ id: new_id });
        var newEntry = clone.appendTo(parent);
        newEntry.find('input').val('');
        entry.find('#entry-button').removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
        return {
            entry: newEntry,
            cond: cond_clone
        }
    }
    
    function filterConditionals() {
        var filters = {};
        $('.clone-home').each(function() {
            var table;
            switch ($(this).prop('table')) {
                case 'cost_centers':
                    table = 'CostCenters';
                    break;
                case 'categories':
                    table = 'Categories';
                    break;
                case 'manufacturers':
                    table = 'Manufacturers';
                    break;
                case 'parts':
                    table = 'Parts';
                    break;
                default:
                    console.log('TABLE NOT RECOGNIZED');
                    return;
            }
            var table_arr = [];
            var clone_home = $(this);
            table_arr = filterContainers($(this));
            if (table_arr.length >= 1 && table_arr[0]) {
                filters[table] = table_arr;
            }
        });
        return filters;
    }
    
    function filterContainers( container ) {
        var filters = [];
        container.find('> .entry, > .well').each(function() {
            var info;
            if ($(this).hasClass('entry')) {
                info = getInfo($(this));
            } else if ($(this).hasClass('well')) {
                var condition = $(this).prop('cond');
                info = {};
                info[condition] = filterContainers($(this));
            }
            filters.push(info);
        });
        return filters;
    }
    
    function getInfo( entry ) {
        var field = entry.find('.field-input').val();
        
        var query = entry.find('.query-input').val();
        
        var operation = entry.find('.operation-input').val();
        if (operation == 'like' && query) {
            operation = 'k';
            var query_ = '%' + query + '%';
            query = query_;
        }
        
        if (field && operation && query) {
            return {
                name: field,
                op: operation,
                val: query
            };
        }
        return false;
    }
    
    function toTitlecase(str) {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    }
</script>