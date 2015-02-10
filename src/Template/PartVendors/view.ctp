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
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($partVendor->id) ?></p>
            <h6 class="subheader"><?= __('Discount') ?></h6>
            <p><?= $this->Number->format($partVendor->discount) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Preferred') ?></h6>
            <p><?= $partVendor->preferred ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related PVRateHistories') ?></h4>
    <?php if (!empty($partVendor->p_v_rate_histories)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('P V Rate Id') ?></th>
            <th><?= __('Part Vendor Id') ?></th>
            <th><?= __('Date') ?></th>
            <th><?= __('Comment') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($partVendor->p_v_rate_histories as $pVRateHistories): ?>
        <tr>
            <td><?= h($pVRateHistories->id) ?></td>
            <td><?= h($pVRateHistories->p_v_rate_id) ?></td>
            <td><?= h($pVRateHistories->part_vendor_id) ?></td>
            <td><?= h($pVRateHistories->date) ?></td>
            <td><?= h($pVRateHistories->comment) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'PVRateHistories', 'action' => 'view', $pVRateHistories->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'PVRateHistories', 'action' => 'edit', $pVRateHistories->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PVRateHistories', 'action' => 'delete', $pVRateHistories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pVRateHistories->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related PartPriceHistories') ?></h4>
    <?php if (!empty($partVendor->part_price_histories)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Part Vendor Id') ?></th>
            <th><?= __('Date Changed') ?></th>
            <th><?= __('Price') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($partVendor->part_price_histories as $partPriceHistories): ?>
        <tr>
            <td><?= h($partPriceHistories->id) ?></td>
            <td><?= h($partPriceHistories->part_vendor_id) ?></td>
            <td><?= h($partPriceHistories->date_changed) ?></td>
            <td><?= h($partPriceHistories->price) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'PartPriceHistories', 'action' => 'view', $partPriceHistories->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'PartPriceHistories', 'action' => 'edit', $partPriceHistories->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PartPriceHistories', 'action' => 'delete', $partPriceHistories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partPriceHistories->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related PartTransactions') ?></h4>
    <?php if (!empty($partVendor->part_transactions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Part Vendor Id') ?></th>
            <th><?= __('Order Num') ?></th>
            <th><?= __('Date') ?></th>
            <th><?= __('Change Qty') ?></th>
            <th><?= __('Price') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($partVendor->part_transactions as $partTransactions): ?>
        <tr>
            <td><?= h($partTransactions->id) ?></td>
            <td><?= h($partTransactions->part_vendor_id) ?></td>
            <td><?= h($partTransactions->order_num) ?></td>
            <td><?= h($partTransactions->date) ?></td>
            <td><?= h($partTransactions->change_qty) ?></td>
            <td><?= h($partTransactions->price) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'PartTransactions', 'action' => 'view', $partTransactions->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'PartTransactions', 'action' => 'edit', $partTransactions->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PartTransactions', 'action' => 'delete', $partTransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partTransactions->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
