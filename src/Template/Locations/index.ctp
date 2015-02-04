<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Location'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parts'), ['controller' => 'Parts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part'), ['controller' => 'Parts', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="locations index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('isle') ?></th>
            <th><?= $this->Paginator->sort('seg') ?></th>
            <th><?= $this->Paginator->sort('shelf') ?></th>
            <th><?= $this->Paginator->sort('box') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($locations as $location): ?>
        <tr>
            <td><?= $this->Number->format($location->id) ?></td>
            <td><?= h($location->name) ?></td>
            <td><?= h($location->isle) ?></td>
            <td><?= $this->Number->format($location->seg) ?></td>
            <td><?= h($location->shelf) ?></td>
            <td><?= $this->Number->format($location->box) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $location->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $location->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?>
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
