<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $partTransaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $partTransaction->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Part Transactions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="partTransactions form large-10 medium-9 columns">
    <?= $this->Form->create($partTransaction); ?>
    <fieldset>
        <legend><?= __('Edit Part Transaction') ?></legend>
        <?php
            echo $this->Form->input('part_vendor_id', ['options' => $partVendors]);
            echo $this->Form->input('order_num');
            echo $this->Form->input('date');
            echo $this->Form->input('change_qty');
            echo $this->Form->input('price');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
