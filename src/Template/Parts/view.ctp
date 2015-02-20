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
    <h2><?= h($part->part_num) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($part->description) ?></p>
            <h6 class="subheader"><?= __('Location') ?></h6>
            <p><?= $part->has('location') ? $this->Html->link($part->location->location_name, ['controller' => 'Locations', 'action' => 'view', $part->location->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Quantity') ?></h6>
            <p><?= $this->Number->format($part->amt_on_hand) ?></p>
            <h6 class="subheader"><?= __('Manufacturer') ?></h6>
            <p><?= $part->has('manufacturer') ? $this->Html->link($part->manufacturer->manufacturer_name, ['controller' => 'Manufacturers', 'action' => 'view', $part->manufacturer->id]) : '' ?></p>
        </div>
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Category') ?></h6>
            <p><?= $part->has('category') ? $this->Html->link($part->category->category_name, ['controller' => 'Categories', 'action' => 'view', $part->category->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Cost Center') ?></h6>
            <p><?= $part->has('cost_center') ? $this->Html->link($part->cost_center->e_code, ['controller' => 'CostCenters', 'action' => 'view', $part->cost_center->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $part->active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
    <div class="row">
        <?php if ($part->has('part_vendors')): ?>
            <div class="large-12 columns strings">
                <h4>Vendors</h4>
                <h6 class="subheader"><?= $this->Html->link(__('Add transaction for a vendor not listed here'), ['controller' => 'PartTransactions', 'action' => 'add', $part->id]) ?></h6>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <?=
                            $this->Html->tableHeaders([
                                'Vendor',
                                'Website',
                                'Preferred',
                                'Price',
                                'Date',
                                ['Actions' => ['class' => 'actions']]
                            ]);
                        ?>
                    </tr>
                    <?php foreach($part->part_vendors as $part_vendor): ?>
                    <tr>
                        <?php $vendor = $part_vendor->vendor; ?>
                        <td><?= $this->Html->link($vendor->vendor_name, ['controller' => 'PartVendors', 'action' => 'view', $part_vendor->id]); ?></td>
                        <td><?= $this->Html->link(__('Click Here'), $vendor->website, ['target' => '_blank']); ?></td>
                        <td><?= $part_vendor->preferred ? 'Yes' : 'No' ?></td>
                        <?php if ($part_vendor->has('part_price_histories') && !empty($part_vendor->part_price_histories)): ?>
                            <?php $history = $part_vendor->part_price_histories[0]; ?>
                            <td>$<?= $history->price ?></td>
                            <td><?= h($history->date_changed) ?></td>
                        <?php else: ?>
                            <td></td>
                            <td></td>
                        <?php endif; ?>
                        <td>
                            <?= $this->Html->link(__('Add Transaction'), ['controller' => 'PartTransactions', 'action' => 'add', $part->id, '?' => ['part_vendor' => $part_vendor->id]]); ?>
                            <br>
                            <?= $this->Html->link(__('View Vendor'), ['controller' => 'Vendors', 'action' => 'view', $vendor->id]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
