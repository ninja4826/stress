<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Part Transaction'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="partTransactions index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <?=
                $this->Html->tableHeaders([
                    'Vendor',
                    'Order Number',
                    'Date',
                    'Quantity',
                    ['Actions' => ['class' => 'actions']]
                ]);
            ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($partTransactions as $partTransaction): ?>
        <?php if ($partTransaction->has('part_vendor') && $partTransaction->part_vendor->has('vendor')): ?>
            <?php $vendor = $partTransaction->part_vendor->vendor; ?>
            <tr>
                <td><?= $this->Html->link($vendor->vendor_name, ['controller' => 'Vendors', 'action' => 'view', $vendor->id]) ?></td>
                <td><?= $partTransaction->order_num ?></td>
                <td><?= $partTransaction->date ?></td>
                <td><?= $partTransaction->change_qty ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $partTransaction->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partTransaction->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $partTransaction->id)]) ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
