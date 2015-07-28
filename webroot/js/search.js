var Search = function(table_info) {
    this.info = JSON.parse(table_info);
    $('.entry-home').prop('cond', 'and');
    
    $('.entry-home').each(function() {
        var table_name = $(this).attr('table');
        
    });
    $(document).on('click', '.entry .entry-button', function(e) {
        var table_name = $(this).parents('.entry').attr('table');
        if ($(this).hasClass('btn-add')) {
            var original = $('.'+table_name+'-entry.entry');
            var clone = original.clone().removeClass('original');
            var table = $('.'+table_name+'-home.entry-home');
            if (table.children('entry').length == 0) {
                clone.appendTo(table);
                
            }
        }
    })
};

Search.prototype = {
    
};