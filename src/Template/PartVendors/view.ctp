<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Part Vendor'), ['action' => 'edit', $partVendor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Part Vendor'), ['action' => 'delete', $partVendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partVendor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['action' => 'add']) ?> </li>
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
<div class="partVendors view large-10 medium-9 columns">
    <h2><?= h($partVendor->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Part') ?></h6>
            <p><?= $partVendor->has('part') ? $this->Html->link($partVendor->part->part_num, ['controller' => 'Parts', 'action' => 'view', $partVendor->part->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Vendor') ?></h6>
            <p><?= $partVendor->has('vendor') ? $this->Html->link($partVendor->vendor->vendor_name, ['controller' => 'Vendors', 'action' => 'view', $partVendor->vendor->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Markup') ?></h6>
            <p><?= h($partVendor->markup) ?></p>
            <h6 class="subheader"><?= __('Discount') ?></h6>
            <p><?= $this->Number->format($partVendor->discount) ?>%</p>
            <h6 class="subheader"><?= __('Preferred') ?></h6>
            <p><?= $partVendor->preferred ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
