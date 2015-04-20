<?php
    $this->append('script', $this->Html->script('form'));
    use Cake\Utility\Inflector;
    $model = $info['name']['model'];
    $table_s = $info['name']['singular']['table'];
    $table_p = $info['name']['plural']['table'];
    $human_s = $info['name']['singular']['human'];
    $human_p = $info['name']['plural']['human'];
    $fields = $info['fields'];
    
    $assocs = [];
    
    $legend = (isset($legend)) ? $legend : 'Add '.$human_s;
?>
<div class="<?=$table_p?> form col-lg-10 col-md-9 columns">
    <?= $this->Form->create(null, ['class' => $table_s.'-form']) ?>
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
        <button type="button" class="btn btn-success" id="<?=$table_s?>-form-submit">Submit</button>
    <?= $this->Form->end() ?>
</div>
<script>
    var form = new Form('<?=$model?>', JSON.parse('<?=json_encode($info)?>'));
</script>