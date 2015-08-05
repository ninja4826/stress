<?php
$this->append('script', $this->Html->script('search'));
$form_fields = [];
foreach (['Parts', 'Categories', 'Manufacturers', 'CostCenters'] as $model_name) {
    $table = Cake\ORM\TableRegistry::get($model_name);
    $fields = $table->getFields();
    $name = Cake\Utility\Inflector::singularize($table->table());
    $form_fields[$table->table()] = [
        'fields' => $fields,
        'name' => $name
    ];
}

$options = [
    'text' => [
        'like',
        '==',
        // 'regexp'
    ],
    'number' => [
        '==',
        '<',
        '>',
        '<=',
        '>='
    ],
    'checkbox' => [
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
        <a href="/search/new"><h1>New Search</h1></a>
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
                                                                                <?php if (array_key_exists('assoc', $props)): ?>
                                                                                    <?php $display_label = $props['assoc']['info']['label']; ?>
                                                                                    <option value="<?=$field?>"><?=$display_label?></option>
                                                                                <?php else: ?>
                                                                                    <option value="<?=$field?>"><?=$props['label']?></option>
                                                                                <?php endif; ?>
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
                                                                        
                                                                        <button type="button" class="btn btn-default btn-add" id="entry-button">
                                                                            <span class="glyphicon glyphicon-plus"></span>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default dropdown-toggle" id="cond-dropdown" data-toggle="dropdown" aria-expanded="false">
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
    var search;
    $(function() {
        search = new Search('<?= json_encode($form_fields) ?>');
    })
</script>