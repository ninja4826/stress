/*
 * GLOBAL FUNCTIONS
 */
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

/*
 * FORM OBJECT DECLARATION
 */
var Form = function( model, info ) {
    console.log(model + ' FORM/MODAL');
    console.log(info);
    if (typeof this.modal === 'undefined') {
        this.modal = false;
        this.src_url = '/form/' + model;
        this.json_url = '/api/info/' + model;
        Form.instance = this;
        this.modals = {};
    } else if (this.modal) {
        this.src_url = '/form/' + model + '?modal=true';
        this.json_url = '/api/info/' + model;
    }
    if (typeof info === 'undefined') {
        var that = this;
        $.getJSON(this.json_url + model, function( data ) {
            that.initialize(model, data['info']);
        });
    } else {
        if ((!('name' in info) || !('fields' in info)) && 'info' in info) {
            info = info['info'];
        }
        this.initialize(model, info);
    }
}
Form.prototype = {
    initialize: function(model, info) {
        
        var that = this;
        this.info = info;
        this.name = info['name'];
        this.fields = info['fields'];
        
        for (var field_name in this.fields) {
            var field = this.fields[field_name];
            this.fields[field_name]['val'] = field['default'];
            if ('display_field' in field && field['display_field']) {
                this.display_field = field_name;
            }
        }
        
        this.check_fields = {};
        this.assoc_fields = {};
        this.dupes = {};
        this.csrf = getCookie('csrfToken');
        for (var field_name in this.fields) {
            var field = this.fields[field_name];
            field['id'] = this.get_selector(field_name);
            if (field['check'] == true) {
                this.check_fields[field_name] = field;
            }
            if ('assoc' in field && field['assoc']) {
                this.assoc_fields[field_name] = field;
                this.check_fields[field_name] = field;
                if (field['assoc']['type'] == 'belongsToMany') {
                    var html_class = this.dashReplace('.' + field_name);
                    var duper = $('#nowhere').find(html_class + '-dupe-group.original-dupe-group');
                    var well = $(field['id'] + '-well');
                    duper.prop('test', 'blah');
                    var clone = duper.clone();
                    clone.removeClass('original-dupe-group').prop('model', this.dashReplace(field_name));
                    clone.find(html_class + '-dupe').removeClass('original-dupe').val(field['default']);
                    clone.appendTo(well);
                    field['id'] = html_class+'-dupe:not(.original-dupe)';
                    field['val'] = {};
                }
                Form.instance.modals[field_name] = new ModalForm(field['assoc']['model'], field_name);
            }
            if ('assoc' in field && !(field['assoc'])) {
                delete field['assoc'];

            }
            if (field['type'] == 'date') {
                $(field['id']+'-picker').datetimepicker();
            }
        }
        this.model_hash = {};
        this.model_name = this.name['model'];
        this.model_hash[this.model_name] = {
            fields: []
        };
        
        for (var field_name in this.check_fields) {
            var field = this.check_fields[field_name];
            if ('assoc' in field) {
                if (!(field['assoc']['model'] in this.model_hash)) {
                    this.model_hash[field['assoc']['model']] = {fields: []};
                }
            } else {
                this.model_hash[this.model_name]['fields'].push(field_name);
            }
        }
        
        if (!this.modal) {
            this.render();
            console.log(this);
        }
    },
    render: function() {
        this.selector = $(this.get_selector(this.info['name']['singular']['table']) + 'Form');
        this.assoc_listen();
        this.submit_listen();this.refresh_items(this.info['search_results']);
        this.assign_typeahead();
        this.display_listen();
        this.many_to_many_listen();
    },
    replaceAll: function( find, replace, str ) {
        return str.replace(new RegExp(find, 'g'), replace);
    },
    dashReplace: function( str ) {
        return this.replaceAll('_', '-', str);
    },
    scoreReplace: function( str ) {
        return this.replaceAll('-', '_', str);
    },
    substringMatcher: function( strs ) {
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
        };
    },
    get_selector: function( field, is_class ) {
        is_class = is_class || false;
        var sel = '#';
        if (is_class) {
            sel = '.';
        }
        return sel + this.dashReplace( field );
    },
    refresh_items: function( data ) {
        var that = this;
        var process_data = function ( data ) {
            var response = data;
            var checks = {};
            var assocs = {};
            for (var check_name in that.check_fields) {
                var check = that.check_fields[check_name];
                if (!('assoc' in check)) {
                    var check_temp = [];
                    for (var item in response[that.name['model']]) {
                        item = response[that.name['model']][item][check_name];
                        check_temp.push(item);
                    }
                    checks[check_name] = check_temp;
                }
            }
            for (var assoc_name in that.assoc_fields) {
                var assoc = that.assoc_fields[assoc_name];
                var assoc_temp = {};
                var check_temp = [];
                console.log('ASSOC RESPONSE');
                for (var item in response[assoc['assoc']['model']]) {
                    console.log('ITEM #' + item);
                    item = response[assoc['assoc']['model']][item];
                    check_temp.push(item['display_name']);
                    assoc_temp[item['display_name']] = item['id'];
                }
                checks[assoc_name] = check_temp;
                assocs[assoc_name] = assoc_temp;
            }
            that.checks = checks;
            that.assocs = assocs;
            for (var field_name in that.fields) {
                $(that.fields[field_name]['id']).trigger('keyup');
            }
        }
        if (typeof data === 'undefined') {
            var json_str = '/api/search?q=' + JSON.stringify(this.model_hash);
            $.getJSON(json_str, function( response ) {
                process_data(response['response']);
            });
        } else {
            process_data(data);
        }
    },
    assoc_listen: function() {
        var fields = this.fields;
        var that = this;
        for (var field_name in fields) {
            var field = fields[field_name];
            var field_id = field['id'];
            console.log('FIELD ID');
            console.log(field_id);
            if (field_name in this.assoc_fields) {
                $(document).on('keyup', field_id, function() {
                // $(field_id).keyup(function() {
                    console.log($(this));
                    field_id = $(this).parents('.form-group').attr('id').split('-').slice(0, -2).join('-');
                    field_name = that.scoreReplace(field_id);
                    field = that.assocs[field_name];
                    var check = '#' + field_id + '-check';
                    var val = $(this).val();
                    if (that.fields[field_name]['assoc']['type'] == 'belongsToMany') {
                        var parent_group = $(this).parents('.input-group');
                        console.log(parent_group);
                        that.fields[field_name]['val'][parent_group.index()] = val;
                        console.log('IS BELONGS TO');
                    } else {
                        that.fields[field_name]['val'] = val;
                    }
                    var add, remove, title;
                    if (!val || !(val in field)) {
                        add = 'remove';
                        remove = 'ok';
                        title = 'This item does not yet exist.';
                    } else {
                        add = 'ok';
                        remove = 'remove';
                        title = 'This item is valid!';
                        
                    }
                    $(check)
                        .parent('[class*="glyph"]')
                        .addClass('glyph-' + add)
                        .removeClass('glyph-' + remove)
                        .attr('data-original-title', title);
                    console.log(field_name);
                    console.log(val);
                    console.log(that.fields);
                });
            } else {
                $(document).on('keyup', field_id, function() {
                    field_id = $(this).attr('id');
                    field_name = that.scoreReplace(field_id);
                    console.log('DUPLICATED KEYUP FUNCTION');
                    var val = $(this).val();
                    that.fields[field_name]['val'] = val;
                });
            }
        }
        $('[data-toggle="tooltip"]').tooltip();
    },
    submit_listen: function() {
        var that = this;
        var btn = this.get_selector(this.name['singular']['table']) + '-form-submit';
        $(btn).on('click', function() {
            that.submit();
        });
    },
    assign_typeahead: function() {
        for (var check_name in this.checks) {
            var check = this.checks[check_name];
            var check_id = $(this.get_selector(check_name));
            var query_arr = {
                filters: {
                    
                }
            };
            var check_f = this.check_fields[check_name];
            var check_m = this.model_name;
            var check_n = check_name;
            if ('assoc' in check_f) {
                check_m = check_f['assoc']['model'];
                check_n = check_f['assoc']['display_field'];
                
                if (check_f['assoc']['type'] == 'belongsToMany') {
                    var html_name = this.dashReplace(check_name)
                    check_id = '.' + html_name + '-dupe';
                    check_id = $(this.get_selector(check_name) + '-well').find('.' + html_name + '-dupe-group:nth-child(1)').find('.' + html_name + '-dupe');
                    console.log('CHECK ID');
                    console.log(check_id);
                }
            }
            console.log('CHECKS');
            console.log(check);
            check_id.typeahead(
                {highlight: true, minLength: 1},
                {source: this.substringMatcher(check)}
            );
        }
    },
    display_listen: function() {
        var that = this;
        if (typeof(this.display_field) == 'undefined') {
            return;
        }
        var field_name = this.display_field;
        $(this.get_selector(field_name)).focusout(function() {
            var field = that.fields[field_name];
            var warning = $(that.selector).find(that.get_selector(that.name['singular']['table'] + '-unique-warning-alert'));
            if (that.checks[field_name].indexOf(field['val']) > -1) {
                warning.slideDown('slow');
            } else {
                warning.slideUp('fast');
            }
        });
    },
    many_to_many_listen: function() {
        var that = this;
        
        for (var field_name in this.assoc_fields) {
            var field = this.assoc_fields[field_name];
            var field_id = field['id'];
            if (field['assoc']['type'] != 'belongsToMany') {
                continue;
            }
            var btn_class_dupe = this.get_selector(field_name) + '-well .dupe-control';
            $(document).on('click', btn_class_dupe, function( event ) {
                event.preventDefault();
                // var well = $(this).parents('.well.well-sm');
                
                var html_model = $(this).parents('.input-group').prop('model');
                console.log('HTML_MODEL');
                console.log(html_model);
                
                var well = $('#' + html_model + '-well');
                
                console.log(well);
                
                var html_name = well.attr('id').split('-').slice(0, -1).join('-');
                var field_name = that.scoreReplace(html_name);
                var dupe_group = $(this).parents('.'+html_name+'-dupe-group');
                
                if (dupe_group.is(':last-child')) {
                    var duper = $('#nowhere').find('.'+html_name+'-dupe-group.original-dupe-group');
                    var clone = duper.clone();
                    clone.removeClass('original-dupe-group').prop('model', html_model);
                    clone.find('.' + html_name + '-dupe').removeClass('original-dupe');
                    clone.appendTo(well);
                    var check = that.checks[field_name];
                    var check_type = clone.find('.'+html_name+'-dupe');
                    var check_f = that.fields[field_name];
                    var check_m = check_f['assoc']['model'];
                    var check_n = check_f['assoc']['display_field'];
                    
                    check_type.typeahead(
                        {highlight: true, minLength: 1},
                        {source: that.substringMatcher(check)}
                    );
                    
                } else {
                    dupe_group.hide();
                    delete that.fields[field_name]['val'][dupe_group.index()];
                }
            });
        }
    },
    get_inputs: function() {
        var data = {};
        for (var field_name in this.fields) {
            var field = this.fields[field_name];
            var val = field['val'];
            if ('assoc' in field) {
                var vals;
                if (field['assoc']['type'] == 'belongsToMany') {
                    vals = field['assoc']['val'];
                } else {
                    
                    vals = {1: val};
                }
                var temp_vals = [];
                for(var val_i in vals) {
                    val = vals[val_i];
                    if (val in this.assocs[field_name]) {
                        val = this.assocs[field_name][val];
                        temp_vals.push(val);
                    } else {
                        this.modals[field_name].selector.find(this.get_selector(field['assoc']['display_field'])).val(val);
                        this.modals[field_name].fields[field['assoc']['display_field']]['val'] = val;
                        this.modals[field_name].show();
                        return false;
                    }
                }
                if (temp_vals.length == 1) {
                    val = temp_vals[0];
                } else {
                    val = temp_vals;
                }
                field_name = field['assoc']['key'];
            } else {
                field_name = field['field_name'];
            }
            data[field_name] = val;
        }
        return data;
    },
    submit: function() {
        var that = this;
        var data = this.get_inputs();
        console.log('DATA');
        console.log(data);
        if (data) {
            // $.post(this.url + this.model_name, data, function( response ) {
            //     that.after_submit( response );
            // });
            $.ajax({
                url: '/api/save/' + this.model_name,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', that.csrf);
                },
                data: data,
                success: function( response ) {
                    that.after_submit( response );
                },
                method: 'POST'
            });
        }
    },
    after_submit: function( response ) {
        if (response['response']['status'] == 'ok') {
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).slideUp('fast');
        } else {
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).slideDown('fast');
        }
    }
};

/*
 * MODALFORM DECLARATION
 */
function ModalForm( model, field_name ) {
    var that = this;
    this.caller = Form.instance;
    this.field_name = field_name;
    this.modal = true;
    $.getJSON('/api/info/' + model, function( data ) {
        // data = data['info'];
        Form.apply(that, [model, data]);
    });
    this.render = function() {
        var that = this;
        $.get(this.src_url + model, function( data ) {
            $(data).appendTo('#modal-container');
            that.assoc_listen();
            that.submit_listen();
            that.form = Form.instance;
            that.selector = $(that.get_selector(that.name['singular']['table']) + 'Modal');
            that.assign_typeahead();
            that.display_listen();
            that.many_to_many_listen();
        });
    };
    this.show = function() {
        console.log(this.selector);
        $(this.selector).modal('show');
    }
    this.after_submit = function( response ) {
        console.log(response);
        if (response['response']['status'] == 'ok') {
            this.caller.refresh_items();
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).hide();
            this.selector.modal('hide');
            var my_val;
            if (typeof(this.display_field) == 'undefined') {
                my_val = '';
            } else {
                my_val = $(this.get_selector(this.display_field)).val();
            }
            $(this.get_selector(this.field_name)).val(my_val);
            this.caller.submit();
        } else {
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).show();
        }
    };
}
ModalForm.prototype = Form.prototype;