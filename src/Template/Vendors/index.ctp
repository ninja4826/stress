<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="vendors index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('comment') ?></th>
            <th><?= $this->Paginator->sort('website') ?></th>
            <th><?= $this->Paginator->sort('email') ?></th>
            <th><?= $this->Paginator->sort('active') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($vendors as $vendor): ?>
        <tr>
            <td><?= $this->Number->format($vendor->id) ?></td>
            <td><?= h($vendor->name) ?></td>
            <td><?= h($vendor->comment) ?></td>
            <td><?= h($vendor->website) ?></td>
            <td><?= h($vendor->email) ?></td>
            <td><?= h($vendor->active) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $vendor->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vendor->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id)]) ?>
            </td>
        </tr>

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
