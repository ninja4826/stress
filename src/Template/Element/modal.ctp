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
                                if ($options['required']) {
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
                                    <?php if ($check): ?>
                                        <div class="input-group">
                                    <?php endif; ?>
                                    <input type="<?=$type?>" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control">
                                    <?php if ($check): ?>
                                        <span class="input-group-addon glyphicon glyphicon-remove" id="<?=$field_html?>-check"></span>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
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
            for(var field in checked) {
                checked_selector += (get_selector(checked[field]) + ', ');
            }
        } else {
            console.log('ELSE');
            checked_selector = get_selector(checked[0]);
        }
        $(checked_selector).focusout(function() {
            // DO STUFF WITH CHECKS.
        });
    });
</script>