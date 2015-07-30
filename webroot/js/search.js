var Search = function(table_info) {
    this.info = JSON.parse(table_info);
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
        $(document).on('click', '.add-entry', function(e) {
            var table_name = $(this).parents('.table-panel').attr('table');
            var original = $('.'+table_name+'-entry.entry.original');
            var clone = original.clone().removeClass('original');
            var in_well = $(this).parents('.entry').attr('welled');
            var parent;
            if (in_well == 'true') {
                parent = $(this).closest('.well');
            } else {
                parent = $('.'+table_name+'-home.entry-home');
            }
            console.log(table_name);
            console.log(parent.attr('cond'));
            var row = $('<div>').addClass('row').addClass('entry-container');
            var condition = $('.'+parent.attr('cond')+'-clone.original').clone().removeClass('original');
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
            var entry1 = original.clone().removeClass('original');
            var entry2 = original.clone().removeClass('original');
            
            var condition = $('.'+$(this).attr('cond')+'-clone.original').clone().removeClass('original');
            entry1.appendTo(well);
            condition.appendTo(well);
            entry2.appendTo(well);
            well.appendTo(table);
        });
        
        $(document).on('change', 'select.field-select', function(e) {
            var val = $(this).val();
            
            
        });
    }
};