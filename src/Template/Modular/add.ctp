<?php
    use Cake\Utility\Inflector;
    
    $dupers = [];
    
    $this->assign('title', $info['name']['plural']['human']);
?>
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
                <div class="<?=$div_class?>" id="<?=$field_html?>-form-group">
                    <?php if ($type == 'checkbox'): ?>
                        <input type="hidden" name="<?=$field_html?>" value="<?=$options['default']?>">
                        <label for="<?=$field_html?>">
                            <input type="checkbox" name="<?=$name?>" value="<?=$options['default']?>" id="<?=$field_html?>">
                            <?=$label?>
                        </label>
                    <?php elseif ($type == 'hidden'): ?>
                        <input type="hidden" name="<?=$field_html?>" value="<?=$options['default']?>" id="<?=$field_html?>">
                    <?php elseif ($type == 'date'): ?>
                        <label for="<?$field_html?>"><?=$label?></label>
                        <div class="input-group date" id="<?=$field_html?>-picker">
                            <input type="text" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control" style="float:none;" value="<?=$options['default']?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    <?php else: ?>
                        <label for="<?=$field_html?>">
                            <?=$label?>
                            <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                                <?php
                                    $tool_title = ($options['assoc']['type'] == 'belongsToMany' ? '&quot;Many to Many&quot; Association' : '&quot;Belongs To&quot; Association');
                                ?>
                                <sup><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="<?=$tool_title?>" data-container="body"></span></sup>
                            <?php endif; ?>
                        </label>
                        <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                            <?php if ($options['assoc']['type'] == 'belongsToMany'): ?>
                                <div class="well well-sm" id="<?=$field_html?>-well"<?=(($options['required']) ? ' required="required"' : '')?>>
                                        <?php $this->append('nowhere'); ?>
                                            <div class="input-group <?=$field_html?>-dupe-group original-dupe-group">
                                                <input type="<?=$type?>" name="<?=$name?>" class="form-control <?=$field_html?>-dupe original-dupe" style="float:none;">
                            <?php else: ?>
                                <div class="input-group">
                                    <input type="<?=$type?>" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control" style="float:none;" value="<?=$options['default']?>">
                            <?php endif; ?>
                        <?php else: ?>
                        <input type="<?=$type?>" name="<?=$name?>" <?=(($options['required']) ? 'required="required" ' : '')?>id="<?=$field_html?>" class="form-control" style="float:none;" value="<?=$options['default']?>"<?= ((array_key_exists('placeholder', $options) && $options['placeholder']) ? 'placeholder="'.$options['placeholder'].'"' : '')?>>
                        <?php endif; ?>
                        <?php if (isset($options['assoc']) && !empty($options['assoc'])): ?>
                            
                            
                            <?php if($options['assoc']['type'] == 'belongsToMany'): ?>
                                <span class="input-group-btn">
                                    <button role="button" class="btn dupe-control">
                                        <span></span>
                                    </button>
                                    <button role="button" class="btn glyph-remove" data-toggle="tooltip" data-placement="left" title="This item does not yet exist." data-container="body">
                                        <span id="<?=$field_html?>-check"></span>
                                    </button>
                                </span>
                            <?php else: ?>
                                <span class="input-group-addon glyph-remove" data-toggle="tooltip" data-placement="left" title="This item does not yet exist." data-container="body"><span id="<?=$field_html?>-check"></span></span>
                            <?php endif; ?>
                            </div>
                            <?php if($options['assoc']['type'] == 'belongsToMany'): ?>
                                <?php $this->end(); ?>
                                </div>
                            <?php endif; ?>
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
<div id="nowhere" style="display:none;">
    <?=$this->fetch('nowhere')?>
</div>
<script>
    var form = new Form('<?=$model?>', JSON.parse('<?=json_encode($info)?>'));
</script>