

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
            $need_vendor = [false];
            if (array_key_exists('part_vendor', $query)) {
                echo $this->Form->hidden('part_vendor_id', ['value' => $query['part_vendor']]);
            } else {
                if (array_key_exists('vendor', $query)) {
                    echo $this->Form->hidden('vendor_name', ['value' => $query['vendor']]);
                } else {
                    echo $this->Form->input('vendor_name', ['type' => 'text', 'label' => 'Vendor']);
                    $need_vendor = [true];
                }
                echo $this->Form->hidden('part_id', ['value' => $part_id]);
            }
            
            echo $this->Form->input('order_num', ['label' => 'Order Number']);
            echo $this->Form->input('date');
            echo $this->Form->input('change_qty', ['label' => 'Quantity']);
            echo $this->Form->input('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script>

    $(document).ready(function() {
        if ($.parseJSON('<?= json_encode($need_vendor) ?>')[0]) {
            var json = $.parseJSON('<?= json_encode($vendors) ?>');
            var options = [];
            for (var k in json) {
                var v = json[k];
                options.push(v);
            }
            console.log(options);
            console.log(json);
            
            $( "#vendor_name" ).autocomplete({
                source: options
            });
        }
    });
</script>
