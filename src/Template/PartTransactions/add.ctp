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
            echo $this->Form->input('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
