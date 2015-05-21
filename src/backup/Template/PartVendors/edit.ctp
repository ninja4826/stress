<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Part Vendor'), ['action' => 'edit', $partVendor->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $partVendor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $partVendor->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['action' => 'add']) ?></li>
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
<div class="partVendors form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($partVendor); ?>
    <fieldset>
        <legend><?= __('Edit Part Vendor') ?></legend>
        <?php
            echo $this->Form->input('part_id', ['options' => $parts]);
            echo $this->Form->input('vendor_id', ['options' => $vendors]);
            echo $this->Form->input('markup');
            echo $this->Form->input('discount');
            echo $this->Form->input('preferred');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
