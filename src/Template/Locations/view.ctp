<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Location'), ['action' => 'edit', $location->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Location'), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parts'), ['controller' => 'Parts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part'), ['controller' => 'Parts', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="locations view large-10 medium-9 columns">
    <h2><?= h($location->location_name) ?></h2>
    <h4 class="subheader"><?= __('Related Parts') ?></h4>
    <?php if (!empty($location->parts)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Part') ?></th>
            <th><?= __('Category') ?></th>
            <th><?= __('Manufacturer') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Amount on Hand') ?></th>
            <th><?= __('Active') ?></th>
            <th><?= __('Cost Center Code') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($parts as $part): ?>
        <tr>
            <td><?= $this->Html->link($part->part_num, ['controller' => 'Parts', 'action' => 'view', $part->id]) ?></td>
            <td><?= $this->Html->link($part->category->category_name, ['controller' => 'Categories', 'action' => 'view', $part->category->id]) ?></td>
            <td><?= $this->Html->link($part->manufacturer->manufacturer_name, ['controller' => 'Manufacturers', 'action' => 'view', $part->manufacturer->id]) ?></td>
            <td><?= h($part->description) ?></td>
            <td><?= $this->Number->format($part->amt_on_hand) ?></td>
            <td><?= $part->active ? 'Yes' : 'No' ?></td>
            <td><?= $this->Html->link($part->cost_center->e_code, ['controller' => 'CostCenters', 'action' => 'view', $part->cost_center->id]) ?></td>
            
            <td class="actions">
                <?= $this->Html->link(__('Edit'), ['controller' => 'Parts', 'action' => 'edit', $part->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Parts', 'action' => 'delete', $part->id], ['confirm' => __('Are you sure you want to delete # {0}?', $part->id)]) ?>
            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
