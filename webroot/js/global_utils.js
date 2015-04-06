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