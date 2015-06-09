<?php
    $this->append('css', $this->Html->css('bootstrap-table.min'));
    $this->assign('title', $info['name']['plural']['human']);
    
    if ($info['parts']) {
        $this->append('script', $this->Html->script('bootstrap-table.bundle'));
        $this->append('css', $this->Html->css('bootstrap-editable'));
    } else {
        $this->append('script', $this->Html->script('bootstrap-table.min'));
    }
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
    .manual {
        margin-right: 4px;
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
        <button type="button" class="btn btn-success manual" step="start">
            Start Manual Edit
        </button>
    <?php endif; ?>
</div>
<table id="<?=$info['name']['plural']['html']?>-table" class="original"
    data-classes="table table-condensed"
    data-pagination="true"
    data-page-size="25"
    data-search="true"
    data-toolbar="#toolbar"
    <?php if ($info['parts']): ?>
        data-click-to-select="true"
        data-checkbox-header="false"
    <?php endif; ?>>
    <thead>
        <tr>
            <th data-field="index"></th>
            <?php if ($info['parts']): ?>
                <th data-field="state" data-checkbox="true"></th>
            <?php endif; ?>
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
            <?php if ($info['parts']): ?>
                <th style="font-size:0.78vw;" data-field="change" data-editable="true" data-classes="change">Amount Changed</th>
                <th data-field="checked"></th>
            <?php endif; ?>
        </tr>
    </thead>
</table>

<script>
    function getCookie(cname) {
        var name = cname + '=';
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    var info;
    var keys = {};
    var vals = {
        assoc: [],
        general: [],
        display: []
    };
    var table;
    $(function() {
        info = JSON.parse('<?=json_encode($info)?>');
        console.log(info);
        var res = info['results'][info['name']['model']];
        for (var i in res) {
            var result = res[i];
            keys[result.display_name] = result.id;
        }
        load(info['results'][info['name']['model']]);
        
        $(document).on('click', '.manual', function() {
            manual($(this));
        });
    });
    function load(data) {
        for (var i in data) {
            data[i].change = null;
            data[i].checked = false;
            data[i].index = parseInt(i);
        }
        
        var sel = '#'+info['name']['plural']['html']+'-table';
        $('#table-holder').empty();
        $('#toolbar.original').clone().removeClass('original').prependTo('#table-row');
        
        var clone = $(sel).clone().removeClass('original').appendTo('#table-holder');
        
        clone.bootstrapTable({
            data: data
        });
        clone.bootstrapTable('hideColumn', 'change');
        clone.bootstrapTable('hideColumn', 'checked');
        clone.bootstrapTable('hideColumn', 'index');
        init_search();
        table = '#'+info['name']['plural']['html']+'-table:not(.original)';
        $(table).find('.bs-checkbox').hide();
        
        $(table).on('check.bs.table', function(e, row) {
            row.checked = true;
        }).on('uncheck.bs.table', function(e, row) {
            row.checked = false;
        }).on('page-change.bs.table', function(number, size) {
            var rows = $(table).bootstrapTable('getData');
            for (var i in rows) {
                if (rows[i].checked) {
                    $(table).bootstrapTable('check', rows[i].index);
                }
            }
        });
        
        $(document).on('editable-save.bs.table', function(a, b, c, d, e) {
            var tr = $(e).parents('tr');
            if (tr.nextAll().is(':visible')) {
                $(e).parents('tr').nextAll('tr:visible').first().find('[data-name="change"]').click();
            }
        });
    }
    
    function manual(obj) {
        var cols = [
            'description',
            'active',
            'location_name',
            'category',
            'cost_center',
            'manufacturer'
        ];
        var funcs = {
            start: function() {
                $('#toolbar:not(.original)').children('button:not([step="start"])').remove();
                $(table).find('.bs-checkbox').show();
                $(obj).attr('step', 'next').text('Next').after($('<button>').addClass('btn btn-danger manual').attr('step', 'cancel').text('Cancel'));
            },
            next: function() {
                
                for (var i in cols) {
                    $(table).bootstrapTable('hideColumn', cols[i]);
                }
                
                $(table).bootstrapTable('showColumn', 'change');
                
                var rows = $(table).bootstrapTable('getData');
                for (var i in rows) {
                    if (!(rows[i].checked)) {
                        $(table).bootstrapTable('hideRow', {index: rows[i].index});
                    }
                }
                $(table).find('.bs-checkbox').hide();
                $(obj).attr('step', 'submit').text('Submit').after($('<button>').addClass('btn btn-warning manual').attr('step', 'back').text('Back'));
            },
            submit: function() {
                var rows = $(table).bootstrapTable('getData');
                var data = {};
                var update_keys = {};
                for (var i in rows) {
                    if (rows[i].checked && rows[i].change != '') {
                        data[rows[i].id] = parseInt(rows[i].change);
                        update_keys[rows[i].id] = rows[i];
                    }
                }
                console.log(data);
                $.ajax({
                    url: '/api/purchase_order?data='+JSON.stringify(data),
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', getCookie('csrfToken'));
                    },
                    data: data,
                    success: function( response ) {
                        var new_data = $(table).bootstrapTable('getData');
                        for (var i in update_keys) {
                            var row = update_keys[i];
                            new_data[row.index] = response['response']['objects'][row.id];
                        }
                        load(new_data);
                    }
                })
            },
            back: function() {
                for (var i in cols) {
                    $(table).bootstrapTable('showColumn', cols[i]);
                }
                $(table).bootstrapTable('hideColumn', 'change');
                manual($(obj).siblings('.btn-success').attr('step', 'start'));
            },
            cancel: function() {
                for (var i in cols) {
                    $(table).bootstrapTable('showColumn', cols[i]);
                }
                $(obj).siblings('.btn-success').attr('step', 'start').text('Start Manual Edit');
                $('#toolbar:not(.original)').children('button:not([step="start"])').remove();
                var rows = $(table).bootstrapTable('getData');
                for (var i in rows) {
                    var row = rows[i];
                    row.checked = false;
                    row.state = false;
                    row.change = '';
                }
                $(table).bootstrapTable('hideColumn', 'change');
                $(table).find('.bs-checkbox').hide();
            },
            
        };
        funcs[$(obj).attr('step')]();
    }
    
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
</script>