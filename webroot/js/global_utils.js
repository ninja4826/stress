function get_inputs( fields ) {
    var data = {};
    for (var field in fields) {
        console.log(field);
        var re = new RegExp('_', 'g');
        var input = $(get_selector(field));
        data[field] = input.val();
    }
    return data;
}
function get_selector( field ) {
    var re = new RegExp('_', 'g');
    var selector = '#' + field.replace(re, '-');
    return selector;
}

function substringMatcher( strs ) {
    return function findMatches(q, cb) {
        var matches, substrRegex;
        
        matches = [];
        
        substrRegex = new RegExp(q, 'i');
        
        $.each(strs, function(i, str) {
            if (substrRegex.test(str)) {
                matches.push({ value: str });
            }
        });
        
        cb(matches);
    }
}

function testModal() {
    $.get('/modal/form?model=Parts', function(data) {
        $(data).appendTo('#content > div.parts.index.col-lg-10.col-md-9.columns');
        $('#partModal').modal('show');
    });
}

function makeTypeAheads( check_arr ) {
    for (var check_name in check_arr) {
        var check = check_arr[check_name];
        var check_id = '#' + replaceAll('_', '-', check_name);
        $(check_id).typeahead(
            {highlight: true, minLength: 1},
            {name: check_name, source: substringMatcher(check)}
        );
    }
}

function replaceAll( find, replace, str ) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function dashReplace( str ) {
    return replaceAll('_', '-', str);
}

function scoreReplace( str ) {
    return replaceAll('-', '_', str);
}
function assocFocusOut( assocs ) {
    for (var assoc_name in assocs) {
        console.log(assoc_name);
        var assoc = assocs[assoc_name];
        console.log(assoc);
        var assoc_id = '#' + dashReplace(assoc_name);
        console.log(assoc_id);
        
        $(assoc_id).focusout(function() {
            console.log('FOCUS LOST');
            
            assoc_id = $(this).attr('id');
            assoc_name = scoreReplace(assoc_id);
            assoc = assocs[assoc_name];
            console.log('ID: ' + assoc_id);
            console.log('NAME: ' + assoc_name);
            console.log('ASSOC:');
            console.log(assoc);
            
            var check = '#' + assoc_id + '-check';
            
            var val = $(this).val();
            
            var remove;
            var add;
            var title;
            if (!val || !(val in assoc)) {
                console.log('not found');
                add = 'remove';
                remove = 'ok';
                title = 'You will be prompted to create this item.';
            } else {
                console.log('FOUND');
                add = 'ok';
                remove = 'remove';
                title = 'This item exists!';
            }
            $(check).addClass('glyphicon-' + add).removeClass('glyphicon-' + remove).attr('data-original-title', title);
            $(check).parent().css('background-color', ((add == 'remove') ? 'red' : 'green'));
        });
    }
}