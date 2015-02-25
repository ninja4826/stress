<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Manufacturer'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="manufacturers index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('manufacturer_name') ?></th>
            <th><?= $this->Paginator->sort('active') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($manufacturers as $manufacturer): ?>
        <tr>
            <td><?= h($manufacturer->manufacturer_name) ?></td>
            <td><?= h($manufacturer->active) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $manufacturer->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $manufacturer->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $manufacturer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manufacturer->id)]) ?>
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
