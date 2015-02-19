

<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Part Transactions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="partTransactions form large-10 medium-9 columns">
    <?= $this->Form->create($partTransaction); ?>
    <fieldset>
        <legend><?= __('Add Part Transaction') ?></legend>
        <?php
            echo $this->Form->hidden('part_vendor_id', ['value' => $partVendor]);
            echo $this->Form->input('test', ['type' => 'string']);
            echo $this->Form->input('order_num', ['label' => 'Order Number']);
            echo $this->Form->input('date');
            echo $this->Form->input('change_qty', ['label' => 'Quantity']);
            echo $this->Form->input('price', ['type' => 'decimal']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    function getVendors(tag, json_str) {
        var json = $.parseJSON(json);
        var vendors = json['vendors'];
        var partVendors = json['part_vendors'];

        $("#test").autocomplete({
            source: vendors
        });

        $('button').click(function() {
            var index = $.inArray($(tag).val(), partVendors);
            if (index == -1) {
                alert('Vendor exists, but is not affiliated with a part. Redirecting to Vendor - Part form.');
                window.location = "<?= $this->Url->build(['controller' => 'PartVendors', 'action' => 'add']) ?>"
            }
        });
    }

    $(document).ready(function() {
        var json = $.parseJSON('<?= json_encode($vendors) ?>');
        var vendors = json['vendors'];
        var partVendors = json['part_vendors'];

        var tag = "#test";

        $(tag).autocomplete({
            source: vendors
        });

        $('button').click(function() {
            var index = $.inArray($(tag).val(), partVendors);
            if (index == -1) {
                alert('Vendor exists, but is not affiliated with a part. Redirecting to Vendor - Part form. ' + json);
                // CHANGE VENDOR_ID AND SUBMIT. ADD EMPTY VENDOR_ID CATCH AND REDIRECT TO VENDOR CREATION.
                // PASS product_id AND vendor_id TO part_vendor CREATION.
                // CREATE TRANSACTION AFTER PART VENDOR HAS BEEN CREATED.
            }
        });
    });
</script>
