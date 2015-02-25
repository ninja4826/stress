<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Part'), ['action' => 'add']) ?></li>
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
<div class="parts index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= __('Part Number') ?></th>
            <th><?= $this->Paginator->sort('manufacturer_id') ?></th>
            <th><?= $this->Paginator->sort('category_id') ?></th>
            <th><?= $this->Paginator->sort('description') ?></th>
            <th><?= __('Amount on Hand') ?></th>
            <th><?= $this->Paginator->sort('location_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($parts as $part): ?>
        <tr>
            <td><?= h($part->part_num) ?></td>
            <td>
                <?= $part->has('manufacturer') ? $this->Html->link($part->manufacturer->manufacturer_name, ['controller' => 'Manufacturers', 'action' => 'view', $part->manufacturer->id]) : '' ?>
            </td>
            <td>
                <?= $part->has('category') ? $this->Html->link($part->category->category_name, ['controller' => 'Categories', 'action' => 'view', $part->category->id]) : '' ?>
            </td>
            <td><?= h($part->description) ?></td>
            <td><?= $this->Number->format($part->amt_on_hand) ?></td>
            <td>
                <?= $part->has('location') ? $this->Html->link($part->location->location_name, ['controller' => 'Locations', 'action' => 'view', $part->location->id]) : '' ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $part->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $part->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $part->id], ['confirm' => __('Are you sure you want to delete # {0}?', $part->id)]) ?>
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
