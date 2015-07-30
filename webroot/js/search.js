var Search = function(table_info) {
    this.info = JSON.parse(table_info);
    console.log(this.info);
    $('.entry-home').prop('cond', 'and');
    $('.table-panel').each(function() {
        var original = $('.add-btn-row.original');
        original.clone().removeClass('original').appendTo($(this).find('fieldset'));
    });
    this.setEventHandlers();
    
        
    // $('.add-entry').trigger('click');
    $('.add-entry').each(function() {
        if ($(this).parents('.original').length == 0) {
            $(this).trigger('click');
        }
    })
};

Search.prototype = {
    setEventHandlers: function() {
        // .add-entry 'OnClick' to create a new entry
        var that = this;
        $(document).on('click', '.add-entry', function(e) {
            var table_name = $(this).parents('.table-panel').attr('table');
            var original = $('.'+table_name+'-entry.entry.original');
            var clone = original.clone().removeClass('original');
            var parent;
            var well = $(this).closest('.well.well-sm');
            if (well.length) {
                parent = well.children('.entry-home');
            } else {
                parent = $('.'+table_name+'-home.entry-home');
            }
            var row = $('<div>').addClass('row').addClass('entry-container');
            var condition = $('.'+parent.attr('cond')+'-clone.original').clone().removeClass('original');
            console.log('CREATED CONDITION');
            console.log(condition);
            clone.appendTo(row);
            condition.appendTo(row);
            row.appendTo(parent);
        });
        
        // .btn-remove 'OnClick' to remove an entry
        $(document).on('click', '.btn-remove', function(e) {
            $(this).parents('.entry:not(.original):not(:first-child)').remove();
        });
        
        $(document).on('click', '.condition', function(e) {
            var table_name = $(this).parents('.table-panel').attr('table');
            var well = $('.well.well-sm.original').clone().removeClass('original');
            var table = $('.'+table_name+'-home.entry-home');
            var original = $('.'+table_name+'-entry.entry.original');
            
            var entry1_container = $('<div>').addClass('row').addClass('entry-container');
            var entry1 = original.clone().removeClass('original');
            
            var entry2_container = $('<div>').addClass('row').addClass('entry-container');
            var entry2 = original.clone().removeClass('original');
            
            var entry_home = $('<div class="entry-home '+table_name+'-home" table="'+table_name+'">');
            
            var condition = $('.'+$(this).attr('cond')+'-clone.original').clone().removeClass('original');
            
            var parent;
            var parent_well = $(this).closest('.well.well-sm');
            if (parent_well.length) {
                parent = parent_well.children('.entry-home');
            } else {
                parent = $('.'+table_name+'-home.entry-home');
            }
            
            entry1.appendTo(entry1_container);
            condition.clone().appendTo(entry1_container);
            
            entry2.appendTo(entry2_container);
            condition.clone().appendTo(entry2_container);
            
            entry1_container.appendTo(entry_home);
            entry2_container.appendTo(entry_home);
            entry_home.attr('cond', $(this).attr('cond'));
            entry_home.appendTo(well);
            
            var pseudo_entry = $('<div class="input-group entry '+table_name+'-entry" table="'+table_name+'">');
            $('.add-btn-row.original').clone().removeClass('original').appendTo(well);
            well.appendTo(pseudo_entry);
            // well.appendTo(table);
            var pseudo_entry_container = $('<div class="row entry-container"');
            pseudo_entry.appendTo(pseudo_entry_container);
            $('.'+parent.attr('cond')+'-clone.original').clone().removeClass('original').appendTo(pseudo_entry_container);
            pseudo_entry_container.appendTo(table);
        });
        
        $(document).on('change', 'select.field-select', function(e) {
            var val = $(this).val();
            console.log($(this));
            var entry = $(this).closest('div.input-group.entry');
            var table = entry.attr('table');
            var field_info = that.info[table][val];
            var ops = {
                'text': [
                    'like',
                    '==',
                    'regexp'
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
            }[field_info['type']];
            console.log(field_info);
            console.log(ops);
            var operation = entry.find('select.operation-select');
            operation.empty();
            for(var op_i in ops) {
                var op = ops[op_i];
                operation.append('<option value="'+op+'">'+op+'</option>');
            }
        });
    },
    get_query: function() {
        var that = this;
        var data = {};
        
        var obtainData = function(selector) {
            var parent = $(selector);
            var cond = parent.attr('cond');
            var arr = [];
            
            parent.children('.entry-container').each(function() {
                var entry = $(this).find('.entry.input-group');
                var field = entry.find('.field-select').val();
                var op = entry.find('.operation-select').val();
                var query = entry.find('.query-input').val();
                console.log(field);
                console.log(op);
                console.log(query);
                arr.push({
                    'name': field,
                    'op': op,
                    'val': query
                });
            });
            if (parent.hasClass('well')) {
                console.log('in well');
            }
            console.log(arr);
        };
        for (var table_name in this.info) {
            var table = $('.entry-home.'+table_name+'-home:not(.original)');
            obtainData('.entry-home.'+table_name+'-home:not(.original)');
        }
    }
};