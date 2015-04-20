<?php
    use Cake\Utility\Inflector;
?>

<?php if ($modal): ?>
    <?php
        
        $model = $info['name']['model'];
        $table_s = $info['name']['singular']['table'];
        $table_p = $info['name']['plural']['table'];
        $human_s = $info['name']['singular']['human'];
        $human_p = $info['name']['plural']['human'];
        $fields = $info['fields'];
        $assocs = [];
        
        $legend = (isset($legend)) ? $legend : 'Add '.$human_s;
        $action = (isset($action)) ? $action : '/'.$table_p.'/add';
    ?>
    <div class="modal fade" id="<?=str_replace('_', '-', $table_s)?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?=$table_s?>ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <?= $this->Form->create(null, ['class' => $table_s.'-form']) ?>
                    <div class="modal-header">
                        <h4 class="modal-title" id="<?=$table_s?>ModalLabel">Create a <?=$human_s?></h4>
                    </div>
                    <div class="modal-body">
                        <div id="<?=$table_s?>-unique-warning-alert" class="alert alert-warning" role="alert" style="display:none;">
                            <strong>Warning!</strong>
                            <p>
                                The current value of the <span id="unique-error-field-name"></span> would cause a discrepancy, and thus cannot be submitted.
                            </p>
                        </div>
                        <div id="<?=$table_s?>-alert" class="alert alert-danger" role="alert" style="display:none;">
                            <strong>Error!</strong>
                            <p>The <?=$human_s?> could not be saved. Please check your fields below.</p>
                        </div>
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
                                        <input type="hidden" name="<?=$field_html?>" value="<?=$options['default']?>">
                                        <label for="<?=$field_html?>">
                                            <input type="checkbox" name="<?=$name?>" value="<?=$options['default']?>" id="<?=$field_html?>">
                                            <?=$label?>
                                        </label>
                                    <?php elseif ($type == 'hidden'): ?>
                                        <input type="hidden" name="<?=$field_html?>" value="<?=$options['default']?>" id="<?=$field_html?>"
                                    <?php else: ?>
                                        <label for="<?=$field_html?>"><?=$label?></label>
                                        <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                            <div class="input-group">
                                        <?php endif; ?>
                                        <input type="<?=$type?>" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control" style="float:none;" value="<?=$options['default']?>">
                                        <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                            <span class="input-group-addon glyph-remove"><span class="glyphicon glyphicon-remove glyph-remove" id="<?=$field_html?>-check" data-toggle="tooltip" data-placement="left" title="This item does not yet exist."></span></span>
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
                        <button type="button" class="btn btn-success" id="<?=str_replace('_', '-', $table_s)?>-form-submit">Submit</button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php
        $this->append('script', $this->Html->script('form'));
        $model = $info['name']['model'];
        $table_s = $info['name']['singular']['table'];
        $table_p = $info['name']['plural']['table'];
        $human_s = $info['name']['singular']['human'];
        $human_p = $info['name']['plural']['human'];
        $fields = $info['fields'];
        
        $assocs = [];
        
        $legend = (isset($legend)) ? $legend : 'Add '.$human_s;
    ?>
    <div class="<?=$table_p?> form col-lg-10 col-md-9 columns" id="<?=$table_s?>Form">
        <?= $this->Form->create(null, ['class' => $table_s.'-form']) ?>
            <div id="<?=$table_s?>-unique-warning-alert" class="alert alert-warning" role="alert" style="display:none;">
                <strong>Warning!</strong>
                <p>
                    The current value of the <span id="unique-error-field-name"></span> would cause a discrepancy, and thus cannot be submitted.
                </p>
            </div>
            <fieldset>
                <legend><?= __($legend) ?></legend>
                <div id="<?=$table_s?>-alert" class="alert alert-danger" role="alert" style="display:none;">
                    <strong>Error!</strong>
                    <p>The <?=$human_s?> could not be saved. Please check your fields below.</p>
                </div>
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
                            <input type="hidden" name="<?=$field_html?>" value="<?=$options['default']?>">
                            <label for="<?=$field_html?>">
                                <input type="checkbox" name="<?=$name?>" value="<?=$options['default']?>" id="<?=$field_html?>">
                                <?=$label?>
                            </label>
                        <?php elseif ($type == 'hidden'): ?>
                            <input type="hidden" name="<?=$field_html?>" value="<?=$options['default']?>" id="<?=$field_html?>"
                        <?php else: ?>
                            <label for="<?=$field_html?>"><?=$label?></label>
                            <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                <div class="input-group">
                            <?php endif; ?>
                            <input type="<?=$type?>" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control" style="float:none;" value="<?=$options['default']?>">
                            <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                <span class="input-group-addon glyph-remove"><span class="glyphicon glyphicon-remove glyph-remove" id="<?=$field_html?>-check" data-toggle="tooltip" data-placement="left" title="This item does not yet exist."></span></span>
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
            <button type="button" class="btn btn-success" id="<?=$table_s?>-form-submit">Submit</button>
        <?= $this->Form->end() ?>
    </div>
    <script>
        var form = new Form('<?=$model?>', JSON.parse('<?=json_encode($info)?>'));
    </script>
<?php endif; ?>