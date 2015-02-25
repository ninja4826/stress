<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Part Transaction'), ['action' => 'edit', $partTransaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Part Transaction'), ['action' => 'delete', $partTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partTransaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Part Transactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="partTransactions view large-10 medium-9 columns">
    <h2><?= h($partTransaction->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Part Vendor') ?></h6>
            <p><?= $partTransaction->has('part_vendor') ? $this->Html->link($partTransaction->part_vendor->id, ['controller' => 'PartVendors', 'action' => 'view', $partTransaction->part_vendor->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($partTransaction->id) ?></p>
            <h6 class="subheader"><?= __('Order Num') ?></h6>
            <p><?= $this->Number->format($partTransaction->order_num) ?></p>
            <h6 class="subheader"><?= __('Change Qty') ?></h6>
            <p><?= $this->Number->format($partTransaction->change_qty) ?></p>
            <h6 class="subheader"><?= __('Price') ?></h6>
            <p><?= $this->Number->format($partTransaction->price) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date') ?></h6>
            <p><?= h($partTransaction->date) ?></p>
        </div>
    </div>
</div>
