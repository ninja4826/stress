<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Cost Center'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="costCenters index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('e_code') ?></th>
            <th><?= $this->Paginator->sort('description') ?></th>
            <th><?= $this->Paginator->sort('active') ?></th>
            <th><?= $this->Paginator->sort('default_value') ?></th>
            <th><?= $this->Paginator->sort('project_number') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($costCenters as $costCenter): ?>
        <tr>
            <td><?= $this->Number->format($costCenter->id) ?></td>
            <td><?= h($costCenter->e_code) ?></td>
            <td><?= h($costCenter->description) ?></td>
            <td><?= h($costCenter->active) ?></td>
            <td><?= h($costCenter->default_value) ?></td>
            <td><?= $this->Number->format($costCenter->project_number) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $costCenter->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $costCenter->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $costCenter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $costCenter->id)]) ?>
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
