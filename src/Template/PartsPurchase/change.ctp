<div class="alert alert-danger alert-dismissible" id="submit-error" role="alert" style="display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Error!</strong> The order was not valid. Please review your order and try again.
</div>
<div class="panel panel-default">
    <div class="panel-body purchase-panel">
        <div class="row" id="add-part-btn" style="margin-bottom:19px;padding-right:15px;">
            <div class="col-lg-2 col-md-2 col-xs-2 pull-right">
                <button class="btn btn-success" style="width:100%">
                    <span class="glyphicon glyphicon-plus"></span> Add Part
                </button>
            </div>
        </div>
        <div class="purchase-group placeholder row well well-sm" style="margin-bottom:19px;margin-right:15px;margin-left:15px;">
            <div class="col-lg-11 col-md-11 col-xs-11">
                <div class="col-lg-5 col-md-5 col-xs-5" style="padding-left:0px;">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Part #
                        </span>
                        <input type="text" class="form-control part-num-input">
                        <span class="input-group-addon glyph-remove">
                            <span></span>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Current
                        </span>
                        <input type="text" class="form-control current-amt" disabled>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4" style="padding-right:0px;">
                    <div class="input-group">
                        <span class="input-group-addon">
                            Change
                        </span>
                        <input type="number" class="form-control amt-input">
                        <span class="input-group-btn">
                            <button class="btn btn-default pos-neg-btn" title="Toggle positive or negative change">
                                <span class="glyph-plus"><span></span></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-xs-1">
                <button class="btn btn-danger remove-group" style="padding:0px;width:100%;height:34px;">
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<div style="padding-top:10px;padding-right:10px;" class="pull-right">
    <button class="btn btn-success purchase-submit">Submit</button>
</div>

<script>

    function getCookie(cname) {
        var name = cname + '=';
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    var purchase_order;

    var PurchaseOrder = function(info) {
        
        this.info = info;
        this.set_btn_click();
        this.set_sources();
        this.set_bloodhound();
        this.assign_listeners();
        
        var original = $('.purchase-group.placeholder');
        var clone = original.clone().removeClass('placeholder');
        clone.find('.pos-neg-btn').prop('val', true);
        this.assign_typeahead(clone);
        $('#add-part-btn').before(clone);
    };
    
    PurchaseOrder.prototype = {
        set_btn_click: function() {
            $(document).on('click', '.pos-neg-btn', function() {
                var val = $(this).prop('val');
                if (typeof(val) === 'undefined') {
                    val = true;
                }
                val = !val;
                
                if (val) {
                    $(this).find('.glyph-minus').addClass('glyph-plus').removeClass('glyph-minus');
                } else {
                    $(this).find('.glyph-plus').addClass('glyph-minus').removeClass('glyph-plus');
                }
                $(this).prop('val', val);
            });
        },
        
        set_sources: function() {
            var sources = [];
            var source_keys = {};
            console.log(this.info.results);
            for (var i in this.info.results) {
                var obj = this.info.results[i];
                sources.push(obj.display_name);
                var source_info = {
                    obj_id: obj.id,
                    results_id: i,
                    // TODO: Add more information as needed
                };
                source_keys[obj.display_name] = source_info;
            }
            
            this.sources = sources.sort();
            this.source_keys = source_keys;
        },
        
        set_bloodhound: function() {
            var sources = this.sources;
            var blood_hound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: sources
            });
            this.blood_hound = blood_hound;
        },
        
        assign_listeners: function() {
            var that = this;
            var keyup_part_num = function() {
                if ($(this).val() in that.source_keys) {
                    var check = $(this).parents('.purchase-group').find('.glyph-remove');
                    check.removeClass('glyph-remove').addClass('glyph-ok');
                    var val = $(this).val();
                    $(this).parents('.purchase-group').find('.current-amt').val(that.info.results[that.source_keys[val].results_id].amt_on_hand);
                } else {
                    var check = $(this).parents('.purchase-group').find('.glyph-ok');
                    check.removeClass('glyph-ok').addClass('glyph-remove');
                    var val = $(this).val();
                    $(this).parents('.purchase-group').find('.current-amt').val('');
                }
            }
            
            $(document).on('click', '#add-part-btn', function() {
                var original = $('.purchase-group.placeholder');
                var clone = original.clone().removeClass('placeholder');
                clone.find('.pos-neg-btn').prop('val', true);
                that.assign_typeahead(clone);
                $('#add-part-btn').before(clone);
            });
            $(document).on('typeahead:select', '.part-num-input.tt-input', keyup_part_num);
            $(document).on('keyup', '.part-num-input.tt-input', keyup_part_num);
            
            $(document).on('click', '.remove-group', function() {
                var purchase_group = $(this).parents('.purchase-group');
                if (!(purchase_group.is(':first-child'))) {
                    purchase_group.remove();
                }
            });
            
            $(document).on('click', '.purchase-submit', function() {
                that.submit();
            })
        },
        
        assign_typeahead: function(el) {
            var input = el.find('.part-num-input');
            input.typeahead(
                {highlight: true, minLength: 1},
                {source: this.blood_hound}
            );
        },
        
        submit_check: function() {
            var that = this;
            var panel = $('.purchase-panel');
            var data = {};
            var error = false;
            panel.find('.purchase-group:not(.placeholder)').each(function(i, el) {
                
                var part_num = $(el).find('.part-num-input.tt-input').val();
                var change = $(el).find('.amt-input').val();
                
                if (part_num != '' && change != '') {
                    var obj = {};
                    var id = that.source_keys[part_num].obj_id;
                    var change = ($(el).find('.amt-input').val() * ($(el).find('.pos-neg-btn').prop('val') ? 1 : -1));
                    if (id in data) {
                        return false;
                    } else {
                        data[id] = change;
                    }
                }
            });
            return data;
        },
        
        submit: function() {
            var data = this.submit_check();
            console.log('DATA');
            console.log(data);
            if (!($.isEmptyObject(data))) {
                
                $.ajax({
                    url: '/api/purchase_order',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', getCookie('csrfToken'));
                    },
                    data: data,
                    success:function( response ) {
                        console.log('RESPONSE');
                        console.log(response);
                        // window.location.href = '..';
                    }
                })
                
                // $.post('/api/purchase_order', data, function(response) {
                //     console.log('RESPONSE');
                //     console.log(response);
                    
                // });
            } else {
                $('#submit-error').slideDown('fast');
            }
        },
    };
    
    $(function() {
        purchase_order = new PurchaseOrder(JSON.parse('<?=json_encode($info)?>'));
    })
</script>