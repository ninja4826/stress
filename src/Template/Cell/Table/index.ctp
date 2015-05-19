<?php
    use Cake\Utility\Inflector;
    
    $model = $info['name']['model'];
?>
<style>
    #test-div {
        position: absolute;
        color: green;
        background-color: green;
        width: 5px;
    }
    .table-condensed td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .table-condensed {
        table-layout: fixed;
    }
    .placeholder {
        position: absolute;
        visibility: hidden;
        display: block;
    }
</style>

<!--<div id="test-carousel" class="carousel slide" data-ride="carousel">-->
<!--    <div class="carousel-inner" role="listbox">-->
<!--        <div class="item active">-->
            
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

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
                            // $out = '<th class="'.$field_name.'-'
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
            <!--<li class="active disabled">-->
            <!--    <a href="#" page="1">1</a>-->
            <!--</li>-->
            <li class="static-button" id="paginator-next">
                <a href="#" aria-label="Next" page="next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
    
<!--<table class="placeholder">-->
<!--    <tbody class="placeholder">-->
        
<!--    </tbody>-->
<!--</table>-->
<script>
    var table;
    $(function() {
        var Table = function( info ) {
            
            var that = this;
            
            console.log('INFO');
            console.log(info);
            
            /*
                TODO{
                    CREATE PAGINATOR;
                    CALCULATE NEEDED AMOUNT OF SPACE;
                    CALCULATE HEIGHT OF PAGINATOR;
                    GET HEIGHT FROM WINDOW - PAGINATOR - OFFSET;
                    SLICE FROM 0 TO NUMBER OF POSSIBLE ROWS;
                    ADD PARAMETERS TO SHOW WHICH INTEGERS TO SLICE WITH.
                    USE PAGINATOR BUTTONS TO CHANGE AND SHOW;
                }
            */
            
            // $('#parts-table').show();
            // return;
            
            
            var model = info['name']['model'];
            this.json_url = '/api/info/' + model;
            this.page = 1;
            
            this.results = info['results'][model];
            console.log('RESULTS');
            console.log(this.results);
            this.info = info;
            this.model = model;
            this.names = info['name'];
            this.table_rows = [];
            
            this.table = $('#' + info['name']['plural']['html'] + '-table');
            
            this.fields = info['fields'];
            // this.results = [];
            
            
            // this.fix_row_count();
            // this.show();
            
            this.init_search();
            
            this.fix_row_count();
            
            // this.show_records();
            console.log('DONE');
            $(document).on('click', '#paginator > li:not(.disabled) > a', function( event ) {
                event.preventDefault();
                var page_num = $(this).attr('page');
                if (page_num == 'next') {
                    that.page++;
                } else if (page_num == 'prev') {
                    that.page--;
                } else {
                    that.page = parseInt($(this).attr('page'));
                }
                that.set_page();
                that.set_paginator();
            });
        };
        
        Table.prototype = {
            fix_row_count: function() {
                
                console.log('ORIGINAL PLACEHOLDER');
                console.log(this.table.find('#placeholder-row'));
                console.log(this.table.find('#placeholder-row').length);
                
                // if (this.table.find('#placeholder-row').length < 1) {
                //     $('#placeholder-row').appendTo(this.table.find('tbody'));
                //     console.log('CREATING NEW ONE');
                // }
                var placeholder = this.table.find('#placeholder-row');
                var pag = $('#paginator-nav');
                
                var row_height = placeholder.height();
                var row_offset = placeholder.offset();
                
                var pag_height = pag.height();
                var pag_offset = pag.offset();
                
                var net_height = $(window).height() - (pag_offset.top + pag_height);
                
                this.num_rows = Math.floor(net_height / row_height);
                // return;
                this.iterate_results();
            },
            iterate_results: function() {
                var result_pages = [];
                var pages = [];
                for (var i = 0; i < this.results.length; i+= this.num_rows) {
                    result_pages.push(this.results.slice(i, i + this.num_rows));
                }
                
                this.result_pages = result_pages;
                
                for (var result_page_i in result_pages) {
                    var result_page = result_pages[result_page_i];
                    var page = [];
                    for (var entity_i in result_page) {
                        var entity = result_page[entity_i];
                        var row = {};
                        for (var field_name in this.fields) {
                            var field = this.fields[field_name];
                            var col;
                            if ('assoc' in field) {
                                col = $('<a>', {
                                    href: (field['assoc']['url'] + '/' + entity[field_name]['id']),
                                    text: entity[field_name]['display_name'],
                                    title: entity[field_name]['display_name']
                                });
                            } else if ('display_field' in field && field['display_field']) {
                                col = $('<a>', {
                                    href: (field['url'] + '/' + entity['id']),
                                    text: entity[field_name],
                                    title: entity[field_name]
                                });
                            } else if (field['type'] == 'checkbox') {
                                col = $('<span>', {
                                    text: (entity[field_name] ? 'Yes' : 'No'),
                                    title: (entity[field_name] ? 'Yes' : 'No')
                                });
                            } else {
                                col = $('<span>', {
                                    text: entity[field_name],
                                    title: entity[field_name]
                                });
                            }
                            row[field_name] = col;
                        }
                        page.push(row);
                    }
                    pages.push(page);
                }
                var that = this;
                
                this.pages = pages;
                this.set_page();
            },
            set_paginator: function() {
                var paginator = $('#paginator');
                
                paginator.find('li').not('.static-button').remove();
                var page_nums = [];
                
                var page = this.page;
                if (this.pages.length >= 5) {
                    if ((page - 2) <= 0) {
                        page = 3;
                    }
                    
                    if ((page + 2) > this.pages.length) {
                        page = this.pages.length - 2;
                    }
                    for (var i = 0; i < 5; i++) {
                        page_nums.push((page - 2) + i);
                    }
                } else {
                    for (var i = 0; i < this.pages.length; i++) {
                        page_nums.push(i + 1);
                    }
                }
                for (var page_num_i in page_nums) {
                    var page_num = page_nums[page_num_i];
                    var l_item = $('<li>');
                    if (this.page == page_num) {
                        l_item.addClass('active');
                    }
                    l_item.append($('<a>', {
                        href: '#',
                        page: page_num,
                        text: page_num
                    }));
                    
                    paginator.find('#paginator-next').before(l_item);
                }
                
                paginator.find('#paginator-prev').removeClass('disabled');
                paginator.find('#paginator-next').removeClass('disabled');
                
                if (this.page <= 1) {
                    paginator.find('#paginator-prev').addClass('disabled');
                }
                
                if (this.page == this.pages.length) {
                    paginator.find('#paginator-next').addClass('disabled');
                }
                
                this.page_nums = page_nums;
            },
            set_page: function() {
                console.log('CHILDREN');
                console.log(this.table.find('tbody').children().not('.placeholder'));
                this.table.find('tbody').children().not('.placeholder').remove();
                var page = this.pages[this.page - 1];
                for (var row_i in page) {
                    var row_arr = page[row_i];
                    var row = $('<tr>');
                    for (var col_i in row_arr) {
                        var col = $('<td>').append(row_arr[col_i]);
                        row.append(col);
                    }
                    this.table.find('tbody').append(row);
                }
                this.set_paginator();
            },
            init_search: function() {
                var sel = ('#' + this.names.plural.html + '-search-input');
                var input = $(sel);
                
                var results = this.results;
                var sources = [];
                
                var source_key = {};
                
                for (var r in results) {
                    var result = results[r];
                    var val = result.display_name;
                    source_key[val] = result.id;
                    sources.push(val);
                }
                
                var blood_hound = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.whitespace,
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: sources
                });
                
                // var engine = blood_hound.initialize();
                
                input.typeahead(
                    {highlight: true, minLength: 1},
                    {name: this.names.plural.table, source: blood_hound}
                );
                
                var that = this;
                $(document).on('typeahead:select', sel, function(search, key) {
                    var id = source_key[key];
                    var url = that.names.plural.table + '/view/' + id;
                    console.log('URL');
                    console.log(url);
                    window.open(url, '_blank');
                });
            }
        };
        table = new Table(JSON.parse('<?=json_encode($info)?>'));
    });
</script>