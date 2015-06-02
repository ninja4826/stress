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
                <th data-field="row" data-visible="false"></th>
                <th style="font-size:0.78vw;" data-field="part_num">Part Number</th>
                <th style="font-size:0.78vw;" data-field="current">Current Amount</th>
                <th style="font-size:0.78vw;" data-field="change" data-editable="true" data-classes="change">Amount Changed</th>
            </tr>
        </thead>
    </table>
<?php endif; ?>
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



    var data;
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
        data = info['results'][info['name']['model']];
        for (var i in data) {
            var obj = data[i];
            keys[obj.display_name] = obj.id;
            data[i].change = '';
            data[i].checked = false;
            data[i].index = parseInt(i);
        }
        
        initial();
        event_listeners();
        
        $(document).on('click', '.manual', function() {
            manual($(this));
        });
    });
    
    function initial() {
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
    }
    
    function event_listeners() {
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
            // start: function() {
            //     $('#table-holder').empty();
            //     var toolbar = $('#toolbar.original').clone().removeClass('original').appendTo('#table-row');
            //     toolbar.find('.manual').attr('step', 'next').text('Next');
            //     $('<button>').addClass('btn btn-danger manual').attr('step', 'cancel').appendTo('#toolbar:not(.original)').text('Cancel');
            //     var clone = $('#parts-table.original').clone().attr('data-click-to-select', 'true').attr('data-checkbox-header', 'true');
            //     clone.find('tr > th:first').before($('<th>').attr('data-field', 'state').attr('data-checkbox', 'true'));
            //     clone.appendTo('#table-holder').removeClass('original');
            //     clone.bootstrapTable({
            //         data: data
            //     });
            //     console.log($(obj));
            // },
            start: function() {
                $('#toolbar:not(.original)').children('button:not([step="start"])').remove();
                $(table).find('.bs-checkbox').show();
                $(obj).attr('step', 'next').text('Next').after($('<button>').addClass('btn btn-danger manual').attr('step', 'cancel').text('Cancel'));
            },
            // next: function() {
            //     var checks = [];
            //     var rows = $('#parts-table').bootstrapTable('getData');
            //     for (var i in rows) {
            //         if (rows[i].state) {
            //             checks.push(rows[i]);
            //             edit_obj[i] = rows[i];
            //         }
            //     }
                
            //     var new_rows = [];
            //     for (var i in checks) {
            //         var check = checks[i];
            //         new_rows.push({
            //             row: new_rows.length,
            //             part_num: check.part_num,
            //             current: check.amt_on_hand,
            //             // change: ('change' in check ? check.change : '')
            //             change: ''
            //         });
            //     }
                
            //     $('#table-holder').empty();
            //     var toolbar = $('#toolbar.original').clone().removeClass('original').appendTo('#table-row');
            //     toolbar.find('.manual').attr('step', 'submit').text('Submit');
            //     $('<button>').addClass('btn btn-warning manual').attr('step', 'back').css('margin-right', 4).appendTo('#toolbar:not(.original)').text('Back');
            //     $('<button>').addClass('btn btn-danger manual').attr('step', 'cancel').appendTo('#toolbar:not(.original)').text('Cancel');
            //     var clone = $('#order-table.original').clone().appendTo('#table-holder').removeClass('original');
            //     clone.bootstrapTable({
            //         data: new_rows
            //     });
                
            //     $(document).on('editable-save.bs.table', function(a, b, c, d, e) {
            //         console.log('SAVED');
            //         $(e).parents('tr').next().find('[data-name="change"]').click();
            //     });
            // },
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
                for (var i in rows) {
                    if (rows[i].checked && rows[i].change != '') data[rows[i].id] = parseInt(rows[i].change);
                }
                console.log(data);
                $.ajax({
                    url: '/api/purchase_order?data='+JSON.stringify(data),
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', getCookie('csrfToken'));
                    },
                    data: data,
                    success: function( response ) {
                        console.log(data);
                        console.log('RESPONSE');
                        console.log(response);
                        // TODO: Update rows and return to index.
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