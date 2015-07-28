<?php
    $operations = [
        'text' => [
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

<div class="search view col-lg-12 col-md-12 columns">
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
                            <?php foreach($info as $table_name => $fields): ?>
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default" id="<?=$table_name?>-panel">
                                        <div class="panel-heading" data-toggle="collapse" data-target="#collapse-<?=$table_name?>" href="#collapse-<?=$table_name?>">
                                            <h4 class="panel-title"><?=ucwords(str_replace("_", " ", $table_name))?></h4>
                                        </div>
                                        <div id="collapse-<?=$table_name?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="<?=$table_name?> form col-lg-12 col-md-12 columns" style="width:100%;">
                                                    <fieldset>
                                                        <div class="row">
                                                            <div class="entry-home <?=$table_name?>-home" table="<?=$table_name?>" style="width:100%;">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="input-group add-group">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn-add entry-btn"></button>
                                                                    <button type="button" class="btn btn-default dropdown-toggle" id="cond-dropdown" data-toggle="dropdown" aria-expanded="false">
                                                                        <span class="caret"> </span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                        <li><a href="#" class="condition or-cond" cond="or">Create an OR condition</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#" class="condition and-cond" cond="and">Create an AND condition</a></li>
                                                                    </ul>
                                                                </span>
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
<div class="hidden">
    <?php foreach($info as $table_name => $fields): ?>
        <div class="input-group entry <?=$table_name?>-entry original" table="<?=$table_name?>">
            <span class="input-group-btn field-select-span">
                <select class="btn field-select">
                    <?php foreach ($fields as $field_name => $field_info): ?>
                        <?php if (array_key_exists('display_field', $field_info) && $field_info['display_field']): ?>
                        <option value="<?=$field_name?>"><?=$field_info['label']?></option>
                    <?php endforeach; ?>
                </select>
            </span>
            <span class="input-group-btn operation-select-span">
                <select class="btn operation-select">
                    <?php foreach($operations['text'] as $op): ?>
                        <option value="<?=$op?>"><?=$op?></option>
                    <?php endforeach; ?>
                </select>
            </span>
            <input type="text" class="form-control query-input">
            <span class="input-group-btn add-btn-group">
                <button type="button" class="btn btn-default btn-remove"><span></span></button>
            </span>
        </div>
    <?php endforeach; ?>
    <p class="text-center cond-sep or-clone original"><em>OR</em></p>
    <p class="text-center cond-sep and-clone original"><em>AND</em></p>
    <div class="well well-sm well-template original">
        <button type="button" class="close" id="well-close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
</div>
<script>
    var search;
    $(function() {
        search = new Search('<?=json_encode($info)?>');
    })
</script>