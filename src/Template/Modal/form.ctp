<?php
    // $info = [
    //     'model' => 'Parts',
    //     'fields' => [
    //         'part_num' => [
    //             'type' => 'text',
    //             'label' => 'Part Number',
    //             'required' => true,
    //             'check' => false
    //         ]
    //     ]
    // ];
    use Cake\Utility\Inflector;
    $table_p = Inflector::underscore($model);
    $table_s = Inflector::singularize($table_p);
    $human_p = Inflector::humanize($table_p);
    $human_s = Inflector::singularize($human_p);
    
    $info = [
        'name' => [
            'singular' => [
                'table' => $table_s,
                'human' => $human_s
            ],
            'plural' => [
                'table' => $table_p,
                'human' => $human_p
            ],
            'model' => $model
        ],
        'fields' => $fields
    ];
    
    $assocs = [];
    
    $legend = (isset($legend)) ? $legend : 'Add '.$human_s;
    $action = (isset($action)) ? $action : '/'.$table_p.'/add';
?>
<div class="modal fade" id="<?=$table_s?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?=$table_s?>ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" accept-charset="utf-8" class="<?=$table_s?>-form" action="<?=$action?>">
                <div class="modal-header">
                    <h4 class="modal-title" id="<?=$table_s?>ModalLabel">Create a <?=$table_s?></h4>
                </div>
                <div class="modal-body">
                    <div id="<?=$table_s?>-alert"></div>
                    <p>The <?=$human_s?> you specified could not be found.</p>
                    <p>If this was a mistake, please correct the mistake and try again. Otherwise, please create a new <?=$human_s?>.</p>
                    <fieldset>
                        <legend><?= __($legend) ?></legend>
                        <?php foreach($fields as $name => $options): ?>
                            <?php
                                $type = (isset($options['type'])) ? $options['type'] : 'text';
                                $label = (isset($options['label'])) ? $options['label'] : Inflector::humanize($name);
                                $div_class = 'form-group '.$type;
                                $field_html = str_replace('_', '-', $name);
                                $default = (isset($options['default'])) ? $options['default'] : '';
                                $check = (isset($options['check'])) ? $options['check'] : false;
                                if (isset($options['required']) && $options['required']) {
                                    $div_class .= ' required';
                                }
                                
                            ?>
                            <div class="<?=$div_class?>">
                                <?php if ($type == 'checkbox'): ?>
                                    <input type="hidden" name="<?=$field_html?>" value="0">
                                    <label for="<?=$field_html?>">
                                        <input type="checkbox" name="<?=$name?>" value="0" id="<?=$field_html?>">
                                        <?=$label?>
                                    </label>
                                <?php else: ?>
                                    <label for="<?=$field_html?>"><?=$label?></label>
                                    <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                        <div class="input-group">
                                    <?php endif; ?>
                                    <input type="<?=$type?>" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control" style="float:none;">
                                    <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove" id="<?=$field_html?>-check"></span></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <?php
                                if ((isset($options['assoc']) && !empty($options['assoc'])) || (isset($options['check']) && $options['check'])) {
                                    $checks[$name] = $options;
                                }
                            ?>
                        <?php endforeach; ?>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="<?=$table_s?>-form-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        
        $('.input-group-addon:has(.glyphicon-remove)').css('background-color', 'red');
        $('.input-group-addon:has(.glyphicon-ok)').css('background-color', 'green');
        
        var info = JSON.parse('<?= json_encode($info) ?>');
        var submit_btn = '#' + info['name']['singular']['table'] + '-form-submit';
        $(document).on('click', submit_btn, function() {
            console.log('button clicked');
            var data = get_inputs(info['fields']);
            console.log(data);
        });
        var checked = [];
        for (var field in info['fields']) {
            if (info['fields'][field]['check'] == true) {
                checked.push(field);
            }
        }
        // console.log(checked);
        var checked_selector = '';
        if (checked.length > 1) {
            checked_selector += get_selector(checked.shift());
            for(var field in checked) {
                checked_selector += (', ' + get_selector(checked[field]));
            }
        } else {
            checked_selector = get_selector(checked[0]);
        }
        $(checked_selector).focusout(function() {
            // DO STUFF WITH CHECKS.
        });
        
        var check_fields = JSON.parse('<?=json_encode($checks)?>');
        console.log('CHECK FIELDS');
        console.log(check_fields);
        var json_str = '/api/search?q=';
        
        var model_hash = {};
        
        var assoc_hash = {};
        var check_arr = [];
        
        var model_name = '<?=$model?>';
        var model = model_name;
        
        for(var field_name in check_fields) {
            var field = check_fields[field_name];
            if ('assoc' in field) {
                model_name = field['assoc']['model'];
                if (!(model_name in model_hash)) {
                    model_hash[model_name] = {fields: []};
                }
                assoc_hash[field_name] = model_name;
            } else {
                if (!(model_name in model_hash)) {
                    model_hash[model_name] = {
                        fields: []
                    };
                }
                model_hash[model_name]['fields'].push(field_name);
                check_arr.push(field_name);
            }
        }
        json_str += JSON.stringify(model_hash);
        var assoc_fields = {};
        var check_fields = {};
        $.getJSON(json_str, function( response ) {
            console.log('RESPONSE');
            console.log(response);
            response = response['response'];
            for (var check in check_arr) {
                check = check_arr[check];
                var check_temp = [];
                for (var item in response[model]) {
                    item = response[model][item];
                    check_temp.push(item[check]);
                }
                check_fields[check] = check_temp;
            }
            for (var assoc in assoc_hash) {
                var assoc_model = assoc_hash[assoc];
                var assoc_temp = {};
                var check_temp = [];
                for (var item in response[assoc_model]) {
                    item = response[assoc_model][item];
                    var temp = {};
                    temp[item['display_name']] = item['id'];
                    check_temp.push(item['display_name']);
                    assoc_temp[item['display_name']] = item['id'];
                }
                assoc_fields[assoc] = assoc_temp;
                check_fields[assoc] = check_temp;
                
            }
            console.log('CHECKS');
            console.log(check_fields);
            console.log('ASSOCS');
            console.log(assoc_fields);
            makeTypeAheads(check_fields);
            assocFocusOut(assoc_fields);
        });
    });
</script>
<?= $this->fetch('modal_script') ?>
<?php $this->assign('modal_script', ''); ?>