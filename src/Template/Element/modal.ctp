<?php
    use Cake\Utility\Inflector;
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
                                        <span class="input-group-addon glyph-remove"><span class="glyphicon glyphicon-remove glyph-remove" id="<?=$field_html?>-check"></span></span>
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
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?= $this->fetch('modal_script') ?>
<?php $this->assign('modal_script', ''); ?>