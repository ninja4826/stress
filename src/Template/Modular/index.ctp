<?php
    $this->append('script', $this->Html->script('table'));
    $this->assign('title', $info['name']['plural']['human']);
?>
<div class="index col-lg-12 col-md-9 columns">
    <div class="row">
        <div class="col-lg-5 col-md-6 col-xs-6 pull-left">
            <h4><?=$info['name']['plural']['human']?></h4>
        </div>
        <form class="col-lg-5 col-md-4 col-xs-6 pull-right" role="search" id="search-form">
            <div class="input-group pull-right">
                <span class="input-group-addon" data-toggle="tooltip" title="Selecting a <?=$info['name']['singular']['human']?> will open a new page." data-placement="left"><span class="glyphicon glyphicon-search"></span></span>
                <input type="text" class="form-control" placeholder="Go To <?=$info['name']['singular']['human']?>" id="<?=$info['name']['plural']['html']?>-search-input">
            </div>
        </form>
    </div>
    <div class="row">
        <div class="well well-sm" id="table-well">
            <table class="table table-condensed" id="<?=$info['name']['plural']['html']?>-table">
                <thead>
                    <tr>
                        <?php
                            foreach($info['fields'] as $field_name => $field) {
                                $out = '<th id="'.$field_name.'-header">'.$field['label'].'</th>';
                                if (array_key_exists('assoc', $field) && array_key_exists('type', $field['assoc']) && $field['assoc']['type'] == 'belongsToMany') {
                                    $out = '';
                                    continue;
                                }
                                echo $out;
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr id="placeholder-row" class="placeholder"><td>A</td></tr>
                </tbody>
            </table>
        </div>
        <nav id="paginator-nav" style="display: table; margin: 0 auto;">
            <ul class="pagination" id="paginator">
                <li class="static-button" id="paginator-prev">
                    <a href="#" aria-label="Previous" page="prev">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="static-button" id="paginator-next">
                    <a href="#" aria-label="Next" page="next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script>
    var table;
    $(function() {
        table = new Table(JSON.parse('<?=json_encode($info)?>'));
    });
</script>