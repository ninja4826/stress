<?php
    $this->append('script', $this->Html->script('bootstrap-table.min'));
    $this->append('css', $this->Html->css('bootstrap-table.min'));
    $this->assign('title', $info['name']['plural']['human']);
?>
<style>
    .bootstrap-table {
        height: 82%;
    }
    .original {
        display: none;
    }
    .hide {
        display: none;
    }
</style>
<div style="position:absolute;" id="test-div"></div>
<div class="index col-lg-12 col-md-12 col-xs-12 columns">
    <div class="row" id="table-row">
        <h4 style="margin-left:15px;"><?=$info['name']['plural']['human']?></h4>
        <div class="col-lg-12 col-md-12 col-xs-12" id="table-holder"></div>
    </div>
</div>
<div id="toolbar" class="original">
    <?php if ($info['parts']): ?>
        <button type="button" class="btn btn-success" id="manual-edit">
            Start Manual Edit
        </button>
    <?php endif; ?>
</div>
<table id="<?=$info['name']['plural']['html']?>-table" class="original"
    data-classes="table table-condensed"
    data-pagination="true"
    data-page-size="25"
    data-search="true"
    data-toolbar="#toolbar">
    <thead>
        <tr>
            <?php
                foreach($info['fields'] as $field_name => $field) {
                    $formatter = 'formatter';
                    if (array_key_exists('display_field', $field) && $field['display_field']) {
                        $formatter = 'displayFormatter';
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
<?php if ($info['parts']): ?>
<?php $this->append('script', $this->Html->script('bootstrap-table-editable.min')); ?>
<?php $this->append('script', $this->Html->script('bootstrap-editable')); ?>
<?php $this->append('css', $this->Html->css('bootstrap-editable')); ?>
    <table id="order-table" class="original"
        data-classes="table table-condensed"
        data-pagination="true"
        data-page-size="25"
        data-search="true"
        data-toolbar="#toolbar">
        <thead>
            <tr>
                <th style="font-size:0.78vw;" data-field="part_num">Part Number</th>
                <th style="font-size:0.78vw;" data-field="current">Current Amount</th>
                <th style="font-size:0.78vw;" data-field="change" data-editable="true">Amount Changed</th>
            </tr>
        </thead>
    </table>
<?php endif; ?>
<script>









// TODO: Use 'state' checkboxes to select initial parts for manual edit.
    // TODO: Create placeholder for new amount input.
    // TODO: Create separate table for purchase order creation.
    // TODO: Use 'insertRow' to add more parts








    var data;
    var info;
    var keys = {};
    var vals = {
        assoc: [],
        general: [],
        display: []
    };
    $(function() {
        info = JSON.parse('<?=json_encode($info)?>');
        data = info['results'][info['name']['model']];
        var sel = '#'+info['name']['plural']['html']+'-table';
        for (var i in data) {
            var obj = data[i];
            keys[obj.display_name] = obj.id;
        }
        
        $('#toolbar.original').clone().removeClass('original').prependTo('#table-row');
        
        var clone = $(sel).clone().removeClass('original').appendTo('#table-holder');
        
        clone.bootstrapTable({
            data: data
        });
        init_search();
        
        $(document).on('click', '#manual-edit', function() {
            $('#table-holder').empty();
            var toolbar = $('#toolbar.original').clone().removeClass('original').appendTo('#table-row');
            toolbar.find('#manual-edit').remove();
            // TODO: Create cancel button
            $('<button>').attr('id', 'manual-next').addClass('btn').addClass('btn-success').text('Next').appendTo('#toolbar');
            var clone = $('#parts-table.original').clone().attr('data-click-to-select', 'true').attr('data-checkbox-header', 'true');
            clone.find('tr > th:first').before($('<th>').attr('data-field', 'state').attr('data-checkbox', 'true'));
            clone.appendTo('#table-holder').removeClass('original');
            console.log(clone);
            clone.bootstrapTable({data: data});
        });
        
        $(document).on('click', '#manual-next', function() {
            var checks = [];
            var rows = $('#parts-table').bootstrapTable('getData');
            for (var i in rows) {
                if (rows[i].state) {
                    checks.push(rows[i]);
                }
            }
            
            var new_rows = [];
            for (var i in checks) {
                var check = checks[i];
                new_rows.push({
                    part_num: check.part_num,
                    current: check.amt_on_hand,
                    change: ''
                });
            }
            
            // TODO: Erase the table and create the new one.
            $('#table-holder').empty();
            var toolbar = $('#toolbar.original').clone().removeClass('original').appendTo('#table-row');
            toolbar.find('#manual-edit').remove();
            // TODO: Create back button
            $('<button>').attr('id', 'manual-submit').addClass('btn').addClass('btn-success').text('Submit').appendTo('#toolbar');
            var clone = $('#order-table.original').clone().appendTo('#table-holder').removeClass('original');
            clone.bootstrapTable({
                data: new_rows
            });
            
            // TODO: Fix onSave event
            // TODO: Fix image loading errors (get from repo)
            $(document).on('save', function(e, editable) {
                console.log('SAVED');
            });
            
        });
    });
    
    function add_inputs() {
        
    }
    
    function init_search() {
        var type_sel = ('div.pull-right.search > input');
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
    }
    
    function displayFormatter(value) {
        vals['display'].push(typeof value);
        return '<a href="/view/'+info['name']['model']+'/'+keys[value]+'" title="'+value+'">'+value+'</a>';
    }
    
    function formatter(value) {
        var type = typeof value;
        
        switch(type) {
            case "string":
                return '<span title="'+value+'">'+value+'</span>';
                break;
            case "number":
                return '<strong>'+value+'</strong>';
                break;
            case "boolean":
                return (value ? 'Yes' : 'No');
                break;
            case "object":
                return '<a href="/view/'+value['table_name']+'/'+value['id']+'" title="'+value['display_name']+'">'+value['display_name']+'</a>';
        }
    }
    
    function stateFormatter(value) {
        console.log(value);
    }
</script>