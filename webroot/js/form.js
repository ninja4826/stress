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
function arrayUnique(array) {
    var a = array.concat();
    for(var i=0; i<a.length; ++i) {
        for(var j=i+1; j<a.length; ++j) {
            if(a[i] === a[j])
                a.splice(j--, 1);
        }
    }

    return a;
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
        this.belongsToMany = [];
        Form.instance = this;
    } else if (this.modal) {
        this.src_url = '/form/' + model + '?modal=true';
        this.json_url = '/api/info/' + model;
    }
    if (typeof info === 'undefined') {
        var that = this;
        $.getJSON(this.json_url, function( data ) {
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
        this.process_alterations = {};
        
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
        
        // if (!this.modal) {
            this.render();
        // }
    },
    render: function() {
        this.selector = $(this.get_selector(this.info['name']['singular']['table']) + 'Form');
        this.assoc_listen();
        this.submit_listen();
        this.refresh_items(this.info['search_results']);
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
    get_selector: function( field, is_class ) {
        is_class = is_class || false;
        var sel = '#';
        if (is_class) {
            sel = '.';
        }
        return sel + this.dashReplace( field );
    },
    refresh_items: function( data, alterations ) {
        var that = this;
        var process_data = function ( data ) {
            console.log(data);
            console.log('PROCESS ALTERATIONS');
            console.log(that.process_alterations);
            for (var model_name in that.process_alterations) {
                var model_arr = that.process_alterations[model_name];
                for (var obj_i in model_arr) {
                    var obj = model_arr[obj_i];
                    var del_obj = false;
                    for (var res_i in data[model_name]) {
                        var res_obj = data[model_name][res_i];
                        if (_.isEqual(res_obj, obj)) {
                            del_obj = true;
                        }
                    }
                    if (del_obj) {
                        delete that.process_alterations[model_name][obj_i];
                    }
                }
                data[model_name] = data[model_name].concat(that.process_alterations[model_name]);
            }
            console.log('EDITED DATA');
            console.log(data);
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
            console.log('PROCESSING DATA');
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
            console.log('NEW ASSOCS');
            console.log(assocs);
            for (var field_name in that.fields) {
                $(that.fields[field_name]['id']).trigger('keyup');
            }
        };
        if (typeof data === 'undefined') {
            console.log('DATA NOT FOUND');
            var json_str = '/api/search?q=' + JSON.stringify(this.model_hash);
            console.log('MODEL HASH');
            console.log(this.model_hash);
            console.log(json_str);
            $.ajax({
                dataType: "json",
                url: json_str,
                async: false,
                success: function( response ) {
                    console.log('FINALLY GOT RESPONSE');
                    console.log(response);
                    if (typeof alterations !== 'undefined') {
                        for (var model_name in alterations) {
                            var model_arr = alterations[model_name];
                            var temp_arr = [];
                            for (var obj_i in model_arr) {
                                var obj = {};
                                for (var obj_key in response['response'][model_name][0]) {
                                    obj[obj_key] = model_arr[obj_i][obj_key];
                                }
                                var in_array = false;
                                for (var res_i in response['response'][model_name]) {
                                    var res_obj = response['response'][model_name][res_i];
                                    if (_.isEqual(res_obj, obj)) {
                                        in_array = true;
                                    }
                                }
                                if (!(in_array)) {
                                    
                                    if (!(model_name in that.process_alterations)) {
                                        that.process_alterations[model_name] = [];
                                    }
                                    that.process_alterations[model_name].push(obj);
                                }
                            }
                        }
                    }
                    process_data(response['response']);
                }
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
                $(document).on('keyup', field_id, function() {
                // $(field_id).keyup(function() {
                    field_id = $(this).parents('.form-group').attr('id').split('-').slice(0, -2).join('-');
                    field_name = that.scoreReplace(field_id);
                    field = that.assocs[field_name];
                    var check = $(this).closest('.input-group').find('#' + field_id + '-check');
                    var val = $(this).val();
                    if (that.fields[field_name]['assoc']['type'] == 'belongsToMany') {
                        var parent_group = $(this).parents('.input-group');
                        that.fields[field_name]['val'][parent_group.index()] = val;
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
                });
                
            } else if (field.type == 'checkbox') {
                $(field_id).change(function() {
                    field_id = $(this).attr('id');
                    field_name = that.scoreReplace(field_id);
                    that.fields[field_name]['val'] = $(this).is(':checked');
                    console.log('CHECKBOX');
                });
                $(field_id).click().click();
            } else {
                $(document).on('keyup', field_id, function() {
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
            var check_id = $(this.get_selector(check_name));
            var query_arr = {
                filters: {
                    
                }
            };
            var belongsToMany = false;
            var check_f = this.check_fields[check_name];
            var check_m = this.model_name;
            var check_n = check_name;
            var html_name;
            if ('assoc' in check_f) {
                check_m = check_f['assoc']['model'];
                check_n = check_f['assoc']['display_field'];
                
                if (check_f['assoc']['type'] == 'belongsToMany') {
                    belongsToMany = true;
                    html_name = this.dashReplace(check_name);
                    check_id = $(this.get_selector(check_name) + '-well').find('.' + html_name + '-dupe-group:nth-child(1)').find('.' + html_name + '-dupe');
                }
            }
            var blood_hound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: check
            })
            check_id.typeahead(
                {highlight: true, minLength: 1},
                {source: blood_hound}
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
                
                var well = $('#' + html_model + '-well');
                
                
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
                    vals = field['val'];
                } else {
                    vals = {0: val};
                }
                var temp_vals = [];
                for(var val_i in vals) {
                    val = vals[val_i];
                    if (val in this.assocs[field_name]) {
                        val = this.assocs[field_name][val];
                        temp_vals.push(val);
                    } else {
                        /**
                         * TODO
                         * SHOW ERRORS RELATED TO ASSOCIATED FIELDS
                         */
                        return false;
                    }
                }
                if (field['assoc']['type'] == 'belongsToMany') {
                    val = {
                        "_ids": temp_vals
                    };
                } else {
                    val = temp_vals[0];
                    field_name = field['assoc']['key'];
                }
            } else {
                field_name = field['field_name'];
            }
            data[field_name] = val;
            console.log(val);
            console.log(typeof(val));
        }
        return data;
    },
    submit: function() {
        var that = this;
        var data = this.get_inputs();
        console.log('DATA');
        console.log(data);
        console.log(JSON.stringify(data));
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
                    console.log(response);
                    that.after_submit( response );
                    
                },
                method: 'POST'
            });
        }
    },
    after_submit: function( response ) {
        if (response['response']['status'] == 'ok') {
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).slideUp('fast');
            console.log('/add/'+this.model_name);
            window.location.href = '/'+this.model_name;
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
            var selector_str = that.get_selector(that.name['singular']['table']) + 'Modal';
            that.selector = $(selector_str);
            that.assign_typeahead();
            that.display_listen();
            that.many_to_many_listen();
            $(document).on('hidden.bs.modal', selector_str, function() {
                // that.refresh_items();
                var my_val;
                if (typeof(that.display_field) == 'undefined') {
                    my_val = '';
                } else {
                    my_val = $(that.get_selector(that.display_field)).val();
                }
                
                $(that.get_selector(that.field_name)).val(my_val);
                that.caller.submit();
            });
        });
    };
    this.show = function() {
        this.selector.modal('show');
    };
    this.after_submit = function( response ) {
        var that = this;
        if (response['response']['status'] == 'ok') {
            
            var entity = response['response']['entity'];
            var temp_dict = {};
            
            temp_dict[entity['table_name']] = [entity];
            
            that.caller.refresh_items(undefined, temp_dict);
            
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).hide();
            this.selector.modal('hide');
        } else {
            this.selector.find(this.get_selector(this.name['singular']['table'] + '-alert')).show();
        }
    };
}
ModalForm.prototype = Form.prototype;