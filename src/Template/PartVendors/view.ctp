<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Part Vendor'), ['action' => 'edit', $partVendor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Part Vendor'), ['action' => 'delete', $partVendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partVendor->id), 'class' => 'btn-danger']) ?> </li>
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
<div class="partVendors view col-lg-10 col-md-9 columns">
    <h2><?= h($partVendor->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Part') ?></h6>
                    <p><?= $partVendor->has('part') ? $this->Html->link($partVendor->part->part_num, ['controller' => 'Parts', 'action' => 'view', $partVendor->part->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Vendor') ?></h6>
                    <p><?= $partVendor->has('vendor') ? $this->Html->link($partVendor->vendor->id, ['controller' => 'Vendors', 'action' => 'view', $partVendor->vendor->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Markup') ?></h6>
                    <p><?= h($partVendor->markup) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($partVendor->id) ?></p>
                    <h6 class="subheader"><?= __('Discount') ?></h6>
                    <p><?= $this->Number->format($partVendor->discount) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Preferred') ?></h6>
                    <p><?= $partVendor->preferred ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related PVRateHistories') ?></h4>
    <?php if (!empty($partVendor->p_v_rate_histories)): ?>
    <div class="table-responsive">
        <table class="table">
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
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'PVRateHistories', 'action' => 'view', $pVRateHistories->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'PVRateHistories', 'action' => 'edit', $pVRateHistories->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'PVRateHistories', 'action' => 'delete', $pVRateHistories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pVRateHistories->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related PartPriceHistories') ?></h4>
    <?php if (!empty($partVendor->part_price_histories)): ?>
    <div class="table-responsive">
        <table class="table">
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
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'PartPriceHistories', 'action' => 'view', $partPriceHistories->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'PartPriceHistories', 'action' => 'edit', $partPriceHistories->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'PartPriceHistories', 'action' => 'delete', $partPriceHistories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partPriceHistories->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
    <h4 class="subheader"><?= __('Related PartTransactions') ?></h4>
    <?php if (!empty($partVendor->part_transactions)): ?>
    <div class="table-responsive">
        <table class="table">
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
                    <?= $this->Html->link('<span class="glyphicon glyphicon-zoom-in"></span><span class="sr-only">' . __('View') . '</span>', ['controller' => 'PartTransactions', 'action' => 'view', $partTransactions->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('View')]) ?>
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['controller' => 'PartTransactions', 'action' => 'edit', $partTransactions->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['controller' => 'PartTransactions', 'action' => 'delete', $partTransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partTransactions->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
</div>
