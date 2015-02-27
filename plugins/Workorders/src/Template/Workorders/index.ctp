<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Workorder'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wo Statuses'), ['controller' => 'WoStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Status'), ['controller' => 'WoStatuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wo Types'), ['controller' => 'WoTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Type'), ['controller' => 'WoTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Staffs'), ['controller' => 'Staffs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Staff'), ['controller' => 'Staffs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Permissions'), ['controller' => 'Permissions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permission'), ['controller' => 'Permissions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wo Tasks'), ['controller' => 'WoTasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Task'), ['controller' => 'WoTasks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wo Update Histories'), ['controller' => 'WoUpdateHistories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Update History'), ['controller' => 'WoUpdateHistories', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="workorders index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('date_received') ?></th>
            <th><?= $this->Paginator->sort('date_required') ?></th>
            <th><?= $this->Paginator->sort('expedite') ?></th>
            <th><?= $this->Paginator->sort('description') ?></th>
            <th><?= $this->Paginator->sort('location') ?></th>
            <th><?= $this->Paginator->sort('date_signed') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($workorders as $workorder): ?>
        <tr>
            <td><?= $this->Number->format($workorder->id) ?></td>
            <td><?= h($workorder->date_received) ?></td>
            <td><?= h($workorder->date_required) ?></td>
            <td><?= h($workorder->expedite) ?></td>
            <td><?= h($workorder->description) ?></td>
            <td><?= h($workorder->location) ?></td>
            <td><?= h($workorder->date_signed) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $workorder->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $workorder->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $workorder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workorder->id)]) ?>
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
