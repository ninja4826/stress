<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Part'), ['action' => 'edit', $part->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Part'), ['action' => 'delete', $part->id], ['confirm' => __('Are you sure you want to delete # {0}?', $part->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Parts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['controller' => 'Manufacturers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manufacturer'), ['controller' => 'Manufacturers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['controller' => 'CostCenters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cost Center'), ['controller' => 'CostCenters', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="parts view large-10 medium-9 columns">
    <h2><?= h($part->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Manufacturer') ?></h6>
            <p><?= $part->has('manufacturer') ? $this->Html->link($part->manufacturer->name, ['controller' => 'Manufacturers', 'action' => 'view', $part->manufacturer->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Category') ?></h6>
            <p><?= $part->has('category') ? $this->Html->link($part->category->id, ['controller' => 'Categories', 'action' => 'view', $part->category->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Part Num') ?></h6>
            <p><?= h($part->part_num) ?></p>
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($part->description) ?></p>
            <h6 class="subheader"><?= __('Location') ?></h6>
            <p><?= $part->has('location') ? $this->Html->link($part->location->id, ['controller' => 'Locations', 'action' => 'view', $part->location->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Cost Center') ?></h6>
            <p><?= $part->has('cost_center') ? $this->Html->link($part->cost_center->id, ['controller' => 'CostCenters', 'action' => 'view', $part->cost_center->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($part->id) ?></p>
            <h6 class="subheader"><?= __('Amt On Hand') ?></h6>
            <p><?= $this->Number->format($part->amt_on_hand) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $part->active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
