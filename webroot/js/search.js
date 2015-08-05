var Search = function(info) {
    this.form_fields = JSON.parse(info);
    this.field_options = {
        'text': [
            'like',
            '==',
            // 'regexp'
        ],
        'number': [
            '==',
            '<',
            '>',
            '<=',
            '>='
        ],
        'checkbox': [
            '==',
            '!='
        ]
    };
    
    this.initialize();
};

Search.prototype = {
    initialize: function() {
        var that = this;
        $('.clone-home').prop('cond', 'and');
        $('.condition').each(function() {
            var cond = $(this);
            cond.prop('cond', cond.attr('cond')).removeAttr('cond');
        });
        
        $('.clone-home').each(function() {
            var table = $(this).attr('table');
            $(this).prop('table', table);
            $(this).removeAttr('table');
        });
        
        this.field_inputs = {
            'parts': {},
            'categories': {},
            'cost_centers': {},
            'manufacturers': {}
        };
        
        $('.entry').each(function(index) {
            var table = $(this).parents('.clone-home').prop('table');
            var id = $(this).attr('id');
            that.field_inputs[table][id] = this;
        });
        
        this.eventListeners();
    },
    
    eventListeners: function() {
        var that = this;
        $(document).on('click', '.btn-add', function() {
            var original = $(this).parents('.entry');
            var parent = original.parent();
            
            var input = that.createInput({
                entry: original,
                parent: parent
            });
            var newEntry = input['entry'];
            var cond = input['cond'];
            newEntry.find('.or-cond').prop('cond', 'or');
            newEntry.find('.and-cond').prop('cond', 'and');
            cond.show();
        });
        
        $(document).on('click', '.btn-remove', function() {
            var entry = $(this).parents('.entry');
            var entry_id = entry.attr('id').toString();
            console.log(entry_id);
            var clone = entry.next('.cond-sep');
            console.log('ENTRY SEPARATOR');
            console.log(clone);
            console.log(clone.prop('under'));
            clone.remove();
            entry.remove();
            
            return false;
        });
        
        $(document).on('change', '.field-input', function() {
            var opt = $(this).parent().siblings('#operation-input-span').find('.operation-input');
            opt.empty();
            var val = $(this).val();
            
            var name = $(this).parents('.clone-home').prop('table');
            var field_type = that.form_fields[name]['fields'][val]['type'];
            $.each(that.field_options[field_type], function(operation) {
                operation = that.field_options[field_type][operation];
                opt.append('<option value="' + operation + '">' + operation + '</option>');
            });
        });
        
        $(document).on('click', '.condition', function() {
            var condition = $(this).prop('cond');
            
            var well = $('#well-clone').clone().prop('cond', condition);
            var entry = $(this).parents('.entry');
            var cloner = entry.parent().children().last();
            console.log(cloner);
            var entry_id = entry.attr('id');
            entry.before(well);
            entry.appendTo(well);
            // var newEntry = createInput(
            //     cloner,
            //     ($(this).attr('cond') === "or")
            // );
            
            var newEntry = that.createInput({
                entry: cloner,
                parent: well
            });
            
            entry.find('#add-btn-group').hide();
            well.removeAttr('id');
            var cond = newEntry['cond'];
            // console.log(cond);
            
            if (cloner.is(':last-child')) {
                cloner.find('#entry-button').removeClass('btn-remove').addClass('btn-add')
                    .removeClass('btn-danger').addClass('btn-success')
                    .html('<span class="glyphicon glyphicon-plus"></span>');
            }
            
            cond.prop('under', entry.attr('id')).show();
            well.show();
        });
        
        $(document).on('click', '#well-close-button', function() {
            var parent = $(this).parent();
            var grandparent = parent.parent();
            
            console.log('Parent');
            console.log(parent);
            console.log('Grandparent');
            console.log(grandparent);
            
            var template_entry = parent.find('.entry:last').attr('id', parent.find('.entry:first').attr('id'));
            var template_id = parseInt(template_entry.attr('id').split('-')[2]);
            console.log('Template');
            console.log(template_entry);
            console.log('Template ID');
            console.log(template_id);
            
            var first_entry = grandparent.find('> .entry:first');
            var first_id = undefined;
            
            if (first_entry.length > 0) {
                first_id = parseInt(first_entry.attr('id').split('-')[2]);
            }
            console.log('First');
            console.log(first_entry);
            console.log('First ID');
            console.log(first_id);
            if (typeof first_id === 'undefined' || first_id >= template_id) {
                template_entry.prependTo(grandparent);
            } else {
                var under;
                grandparent.find('.cond-sep').each(function() {
                    if ($(this).prop('under') == template_entry.attr('id')) {
                        under = $(this);
                    }
                });
                console.log('UNDER');
                console.log(under);
                under.before(template_entry);
            }
            template_entry.find('#add-btn-group').show();
            parent.remove();
            if (!(template_entry.is(':last-child'))) {
                template_entry.find('#entry-button').removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }
        });
        
        $(document).on('click', '#search-form-submit', function() {
            var arr = {
                filters: that.filterConditionals()
            };
            $('#search-form-submit').button('loading');
            if ($.isEmptyObject(arr['filters']) > 0) {
                $(this).popover('show');
                var button = $(this);
                setTimeout(function() {
                    button.popover('hide');
                }, 2000);
            }
            console.log('SENT DATA');
            console.log(arr);
            console.log('JSON REP');
            console.log(JSON.stringify(arr));
            that.getResults(arr);
            
            $('#search-form-submit').button('reset');
            $('#search-panel > .panel-heading').trigger('click');
        });
        
        $('.panel-heading').hover(function() {
            $(this).parents('.panel:first').removeClass('panel-default').addClass('panel-success');
        }, function() {
            $(this).parents('.panel:first').removeClass('panel-success').addClass('panel-default');
        });
    },
    
    getResults: function(data) {
        $('#results').load('/search?q=' + JSON.stringify(data), function() {
            $('.results-panel').find('.panel-heading').trigger('click');
            $('#results-panel').find('.panel-heading').trigger('click');
            $('html, body').animate({ scrollTop: $('#results').offset().top }, 1000);
            $('.panel-heading').hover(function() {
                $(this).parents('.panel:first').removeClass('panel-default').addClass('panel-success');
            }, function() {
                $(this).parents('.panel:first').removeClass('panel-success').addClass('panel-default');
            });
        });
    },
    
    createInput: function(options) {
        var entry;
        if ('entry' in options) {
            entry = options['entry'];
        } else {
            return {
                entry: null,
                cond: null
            };
        }
        
        var parent = ('parent' in options ? options['parent'] : entry.parent());
        
        var condition = parent.prop('cond');
        
        var cond_clone = $('#' + condition + '-clone').clone().removeAttr('id');
        
        cond_clone.prop('under', entry.prop('id')).appendTo(parent);
        
        var table = entry.parents('.clone-home').prop('table');
        var old_id_num = entry.attr('id').split('-')[2];
        var new_id = table + '-input-' + (parseInt(old_id_num, 10) + 1).toString();
        var controlForm = $('#search-form');
        var clone = entry.clone().prop({ id: new_id });
        var newEntry = clone.appendTo(parent);
        newEntry.find('input').val('');
        entry.find('#entry-button').removeClass('btn-add').addClass('btn-remove');
        return {
            entry: newEntry,
            cond: cond_clone
        }
    },
    
    filterConditionals: function() {
        var that = this;
        var filters = {};
        $('.clone-home').each(function() {
            var table;
            switch ($(this).prop('table')) {
                case 'cost_centers':
                    table = 'CostCenters';
                    break;
                case 'categories':
                    table = 'Categories';
                    break;
                case 'manufacturers':
                    table = 'Manufacturers';
                    break;
                case 'parts':
                    table = 'Parts';
                    break;
                default:
                    console.log('TABLE NOT RECOGNIZED');
                    return;
            }
            var table_arr = [];
            var clone_home = $(this);
            table_arr = that.filterContainers($(this), $(this).prop('table'));
            if (table_arr.length >= 1 && table_arr[0]) {
                filters[table] = table_arr;
            }
        });
        return filters;
    },
    
    filterContainers: function(container, table) {
        var that = this;
        var filters = [];
        container.find('> .entry, > .well').each(function() {
            var info;
            if ($(this).hasClass('entry')) {
                info = that.getInfo($(this), table);
            } else if ($(this).hasClass('well')) {
                var condition = $(this).prop('cond');
                info = {};
                info[condition] = that.filterContainers($(this));
            }
            filters.push(info);
        });
        console.log('IN FILTERCONTAINERS');
        console.log(this.form_fields);
        return filters;
    },
    
    getInfo: function(entry, table) {
        var field = entry.find('.field-input').val();
        
        var query = entry.find('.query-input').val();
        
        var operation = entry.find('.operation-input').val();
        
            
        if (operation == 'like' && query) {
            operation = 'k';
            var query_ = '%' + query + '%';
            query = query_;
        }
        
        if (field && operation && query) {
            var data = {
                name: field,
                op: operation,
                val: query
            }
            console.log(table)
            if ('assoc' in this.form_fields[table]['fields'][field]) {
                data['fk'] = this.form_fields[table]['fields'][field]['assoc']['model'];
                data['name'] = this.form_fields[table]['fields'][field]['assoc']['info']['field_name'];
            }
            return data;
        }
        return false;
    },
    
    toTitlecase: function(str) {
        return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
    }
}