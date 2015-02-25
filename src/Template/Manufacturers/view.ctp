<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Manufacturer'), ['action' => 'edit', $manufacturer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Manufacturer'), ['action' => 'delete', $manufacturer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manufacturer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manufacturer'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="manufacturers view large-10 medium-9 columns">
    <h2><?= h($manufacturer->manufacturer_name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($manufacturer->manufacturer_name) ?></p>
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $manufacturer->active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
