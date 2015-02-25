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
        <?php if ($partVendor->has('part_price_histories')): ?>
            <div class="large-6 columns strings">
                <h4>Price Histories</h4>
                <h6 class="subheader"><?= $this->Html->link(__('Add Transaction'), ['controller' => 'PartTransactions', 'action' => 'add', $partVendor->id]); ?></h6>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <?=
                            $this->Html->tableHeaders([
                                'Date',
                                'Price',
                                ['Actions' => ['class' => 'actions']]
                            ]);
                        ?>
                    </tr>
                    <?php foreach($partVendor->part_price_histories as $hist): ?>
                        <tr>
                            <?php $hist = json_decode(json_encode($hist), true); ?>
                            <td><?= $this->Time->nice($hist['date_changed'], 'America/Chicago') ?></td>
                            <td>$<?= h($hist['price']) ?></td>
                            <td>
                                <?= $this->Html->link(__('View'), ['controller' => 'PartPriceHistories', 'action' => 'view', $hist['id']]); ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PartPriceHistories', 'action' => 'edit', $hist['id']]); ?>
                                <?= $this->Html->link(__('Delete'), ['controller' => 'PartPriceHistories', 'action' => 'delete', $hist['id']], ['confirm' => __('Are you sure you want to delete # {0}', $hist['id'])]); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <h6 class="subheader"><?= $this->Html->link(__('View all transactions'), ['controller' => 'PartTransactions', 'action' => 'index', $partVendor->id]); ?></h6>
            </div>
        <?php endif; ?>
    </div>
</div>
