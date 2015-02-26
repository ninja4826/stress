<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Staffs'), ['controller' => 'Staffs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Staff'), ['controller' => 'Staffs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Permissions'), ['controller' => 'Permissions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permission'), ['controller' => 'Permissions', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="users index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('username') ?></th>
            <th><?= __('Staff') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= h($user->username) ?></td>
            <td>
                <?= $user->has('staff') ? $this->Html->link($user->staff->full_name, ['controller' => 'Staffs', 'action' => 'view', $user->staff->id]) : '' ?>
            </td>
            <td><?= h($user->created) ?></td>
            <td><?= h($user->modified) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
