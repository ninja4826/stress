<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Part Vendors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Parts'), ['controller' => 'Parts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part'), ['controller' => 'Parts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List P V Rate Histories'), ['controller' => 'PVRateHistories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New P V Rate History'), ['controller' => 'PVRateHistories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Part Price Histories'), ['controller' => 'PartPriceHistories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Price History'), ['controller' => 'PartPriceHistories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Part Transactions'), ['controller' => 'PartTransactions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Transaction'), ['controller' => 'PartTransactions', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="partVendors form large-10 medium-9 columns">
    <?= $this->Form->create($partVendor); ?>
    <fieldset>
        <legend><?= __('Add Part Vendor') ?></legend>
            <?php
                if (is_null($parts)) {
                    echo $this->Form->hidden('part_id', ['value' => $q['part']]);
                } else {
                    echo $this->Form->input('part_id', ['options' => $parts]);
                }
                if (is_null($vendors)) {
                    echo $this->Form->hidden('vendor_id', ['value' => $q['vendor']]);
                } else {
                    echo $this->Form->input('vendor_id', ['options' => $vendors]);
                }
            ?>
            
            <?= $this->Form->input('markup') ?>
            <?= $this->Form->input('discount') ?>
            <?= $this->Form->input('preferred') ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
