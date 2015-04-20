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
                Form.instance.modals[field_name] = new ModalForm(field['assoc']['model'], field_name);
            }
            if ('assoc' in field && !(field['assoc'])) {
                delete field['assoc'];
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
        
        if (this.modal) {
            this.render();
        } else {
            this.selector = $(that.get_selector(info['name']['singular']['table']) + 'Form');
            this.assoc_listen();
            this.submit_listen();
        }
        this.refresh_items(this.info['search_results']);
        this.assign_typeahead();
        this.display_listen();
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
    get_selector: function( field ) {
        return '#' + this.dashReplace( field );
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
                for (var item in response[assoc['assoc']['model']]) {
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
            
            if (field_name in this.assoc_fields) {
                $(field_id).keyup(function() {
                    field_id = $(this).attr('id');
                    field_name = that.scoreReplace(field_id);
                    field = that.assocs[field_name];
                    var check = '#' + field_id + '-check';
                    var val = $(this).val();
                    that.fields[field_name]['val'] = val;
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
                        .addClass('glyphicon-' + add)
                        .removeClass('glyphicon-' + remove)
                        .add($(check).parent())
                        .addClass('glyph-' + add)
                        .removeClass('glyph-' + remove);
                });
            } else {
                $(field_id).keyup(function() {
                    field_id = $(this).attr('id');
                    field_name = that.scoreReplace(field_id);
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
            var check_id = this.get_selector(check_name);
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
            }
            
            $(check_id).typeahead(
                {highlight: true, minLength: 1},
                {name: check_name, source: this.substringMatcher(check)}
            );
        }
    },
    display_listen: function() {
        var that = this;
        var field_name = this.display_field;
        $(this.get_selector(field_name)).focusout(function() {
            var field = that.fields[field_name];
            var warning = $(that.selector).find(that.get_selector(that.name['singular']['table'] + '-unique-warning-alert'));
            if (that.checks[field_name].indexOf(field['val']) > -1) {
                // warning.find('#unique-error-field-name').html(field_name);
                warning.slideDown('slow');
            } else {
                warning.slideUp('fast');
            }
        });
    },
    get_inputs: function() {
        var data = {};
        for (var field_name in this.fields) {
            var field = this.fields[field_name];
            var val = field['val'];
            if ('assoc' in field) {
                if (val in this.assocs[field_name]) {
                    val = this.assocs[field_name][val];
                } else {
                    this.modals[field_name].selector.find(this.get_selector(field['assoc']['display_field'])).val(val);
                    this.modals[field_name].fields[field['assoc']['display_field']]['val'] = val;
                    this.modals[field_name].show();
                    console.log('MODALS');
                    console.log(this.modals);
                    console.log('FIELD NAME');
                    console.log(field_name);
                    console.log('TARGET MODAL');
                    console.log(this.modals[field_name]);
                    return false;
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
            var my_val = $(this.get_selector(this.display_field)).val();
            $(this.get_selector(this.field_name)).val(my_val);
            this.caller.submit();
        } else {
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).show();
        }
    };
}
ModalForm.prototype = Form.prototype;