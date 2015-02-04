<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vendor'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="vendors view large-10 medium-9 columns">
    <h2><?= h($vendor->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($vendor->name) ?></p>
            <h6 class="subheader"><?= __('Comment') ?></h6>
            <p><?= h($vendor->comment) ?></p>
            <h6 class="subheader"><?= __('Website') ?></h6>
            <p><?= h($vendor->website) ?></p>
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($vendor->email) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($vendor->id) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $vendor->active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
