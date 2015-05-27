<div class="panel panel-default">
    <div class="panel-body purchase-panel">
        <div class="purchase-group placeholder row" style="margin-bottom:19px;">
            <div class="col-lg-6 col-md-6 col-xs-6">
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
            <div class="col-lg-2 col-md-2 col-xs-2">
                <div class="input-group">
                    <span class="input-group-addon">
                        Current
                    </span>
                    <input type="text" class="form-control current-amt" disabled>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-4">
                <div class="input-group">
                    <span class="input-group-addon">
                        Change
                    </span>
                    <input type="number" class="form-control amt-input">
                    <span class="input-group-btn">
                        <button class="btn btn-success pos-neg-btn">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="padding-top:10px;padding-right:10px;" class="pull-right">
    <button class="btn btn-success">Submit</button>
</div>

<script>

    var purchase_order;

    var PurchaseOrder = function(info) {
        
        this.info = info;
        this.set_btn_click();
        this.set_sources();
        this.set_bloodhound();
        this.set_duper();
        
        var original = $('.purchase-group.placeholder');
        var clone = original.clone().removeClass('placeholder');
        this.assign_typeahead(clone);
        original.before(clone);
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
                    $(this).addClass('btn-success').removeClass('btn-danger');
                    $(this).find('.glyphicon').addClass('glyphicon-plus').removeClass('glyphicon-minus');
                } else {
                    $(this).addClass('btn-danger').removeClass('btn-success');
                    $(this).find('.glyphicon').addClass('glyphicon-minus').removeClass('glyphicon-plus');
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
            
            this.sources = sources;
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
        
        set_duper: function() {
            var that = this;
            var keyup_amt = function() {
                if ($(this).parents('.purchase-group').find('.part-num-input.tt-input').val() != '') {
                    var original = $('.purchase-group.placeholder');
                    var clone = original.clone().removeClass('placeholder');
                    that.assign_typeahead(clone);
                    original.before(clone);
                }
            }
            var keyup_part_num = function() {
                if ($(this).parents('.purchase-group').find('.amt-input').val() != '') {
                    var original = $('.purchase-group.placeholder');
                    var clone = original.clone().removeClass('placeholder');
                    that.assign_typeahead(clone);
                    original.before(clone);
                }
                
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
            $(document).on('keyup', '.amt-input', keyup_amt);
            $(document).on('typeahead:select', '.part-num-input.tt-input', keyup_part_num);
            $(document).on('keyup', '.part-num-input.tt-input', keyup_part_num);
        },
        
        assign_typeahead: function(el) {
            var input = el.find('.part-num-input');
            input.typeahead(
                {highlight: true, minLength: 1},
                {source: this.blood_hound}
            );
        },
        
        submit_check: function() {
            var panel = $('.purchase-panel');
            var data = [];
            panel.find('.purchase-group:not(.placeholder)').each(function(i, el) {
                var obj = {};
                obj.part_num = $(el).find('.part-num-input.tt-input').val();
                obj.amt = $(el).find('.amt-input').val();
                if (obj.part_num != '' && obj.amt != '') {
                    data.push(obj);
                }
            });
            this.data = data;
            console.log(data);
        },
        
        submit: function() {
            
        },
    };
    
    $(function() {
        purchase_order = new PurchaseOrder(JSON.parse('<?=json_encode($info)?>'));
    })
</script>