<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Parts'), ['action' => 'index']) ?></li>
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
<div class="parts form large-10 medium-9 columns">
    <?= $this->Form->create($part); ?>
    <fieldset>
        <legend><?= __('Add Part') ?></legend>
        <?php
            echo $this->Form->input('manufacturer_id', ['options' => $manufacturers]);
            echo $this->Form->input('category_id', ['options' => $categories]);
            echo $this->Form->input('part_num', ['default' => '248']);
            echo $this->Form->input('description', ['default' => 'weoib']);
            echo $this->Form->input('amt_on_hand', ['default' => 4]);
            echo $this->Form->input('location_id', ['options' => $locations]);
            echo $this->Form->input('location_name', ['type' => 'text']);
            echo $this->Form->input('active');
            echo $this->Form->input('cc_id', ['options' => $costCenters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
