<?php
    $this->append('script', $this->Html->script('bootstrap-table.min'));
    $this->append('css', $this->Html->css('bootstrap-table.min'));
    $this->assign('title', $info['name']['plural']['human']);
?>
<div class="index col-lg-12 col-md-12 col-xs-12 columns">
    <!--<div class="row">-->
    <!--    <div class="col-lg-6 col-md-6 col-xs-6 pull-left">-->
    <!--        <h4><?=$info['name']['plural']['human']?></h4>-->
    <!--    </div>-->
    <!--    <div class="col-lg-6 col-md-6 col-xs-6 pull-right">-->
    <!--        <?php if ($info['parts']): ?>-->
    <!--            <form class="col-lg-5 col-md-5 col-xs-5" action="/parts_change">-->
    <!--                <button class="btn btn-success" id="manual-edit" style="width:100%;">Start Manual Edit</button>-->
    <!--            </form>-->
    <!--        <?php endif; ?>-->
    <!--        <form class="col-lg-7 col-md-7 col-xs-7 pull-right" role="search" id="search-form" style="padding-right:0px;">-->
    <!--            <div class="input-group pull-right">-->
    <!--                <span class="input-group-addon" data-toggle="tooltip" title="Selecting a <?=$info['name']['singular']['human']?> will open a new page." data-placement="left"><span class="glyphicon glyphicon-search"></span></span>-->
    <!--                <input type="text" class="form-control" placeholder="Go To <?=$info['name']['singular']['human']?>" id="<?=$info['name']['plural']['html']?>-search-input">-->
    <!--            </div>-->
    <!--        </form>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="row" id="table-row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <div id="toolbar">
                <?php if ($info['parts']): ?>
                    <button type="button" class="btn btn-success pull-right" id="manual-edit" style="">
                        Start Manual Edit
                    </button>
                <?php endif; ?>
            </div>
            <h4><?=$info['name']['plural']['human']?></h4>
            <table id="<?=$info['name']['plural']['html']?>-table"
                data-classes="table table-condensed"
                data-pagination="true"
                data-page-size="25"
                data-search="true"
                data-toolbar="#toolbar"
                <?php if ($info['parts']): ?>
                
                    data-click-to-select="true"
                <?php endif; ?>
                >
                <thead>
                    <tr>
                        <?php if ($info['parts']): ?>
                            <th data-field="state" data-checkbox="true"></th>
                        <?php endif; ?>
                        <?php
                            foreach($info['fields'] as $field_name => $field) {
                                $formatter = '';
                                if (array_key_exists('assoc', $field)) {
                                    $formatter = 'assocFormatter';
                                } else if (array_key_exists('display_field', $field) && $field['display_field']) {
                                    $formatter = 'displayFormatter';
                                } else {
                                    $formatter = 'generalFormatter';
                                }
                                
                                $out = '<th id="'.$field_name.'-header" style="font-size:0.78vw;" data-field="'.$field_name.'" data-formatter="'.$formatter.'">'.$field['label'].'</th>';
                                if (array_key_exists('assoc', $field) && array_key_exists('type', $field['assoc']) && $field['assoc']['type'] == 'belongsToMany') {
                                    $out = '';
                                    continue;
                                }
                                echo $out;
                            }
                        ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>









// TODO: Use 'state' checkboxes to select initial parts for manual edit.









    var data;
    var info;
    var keys = {};
    $(function() {
        info = JSON.parse('<?=json_encode($info)?>');
        data = info['results'][info['name']['model']];
        var sel = '#'+info['name']['plural']['html']+'-table';
        for (var i in data) {
            var obj = data[i];
            keys[obj.display_name] = obj.id;
        }
        $(sel).bootstrapTable({
            data: data
        });
        
        init_search();
    });
    
    function init_search() {
        var type_sel = ('#' + info.name.plural.html + '-search-input');
        var input = $(type_sel);
        
        var results = info.results[info.name.model];
        var sources = [];
        for (var r in results) {
            sources.push(results[r].display_name);
        }
        
        var blood_hound = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: sources
        });
        input.typeahead(
            {highlight: true, minLength: 1},
            {name: info.name.plural.table, source: blood_hound}
        );
        
        $(document).on('typeahead:select', type_sel, function(search, key) {
            var id = keys[key];
            var url = '/view/' + info.name.plural.table + '/' + id;
            window.open(url, '_blank');
        });
    }
    
    function assocFormatter(value) {
        return '<a href="/view/'+value['table_name']+'/'+value['id']+'" title="'+value['display_name']+'">'+value['display_name']+'</a>';
    }
    
    function displayFormatter(value) {
        return '<a href="/view/'+info['name']['model']+'/'+keys[value]+'" title="'+value+'">'+value+'</a>';
    }
</script>