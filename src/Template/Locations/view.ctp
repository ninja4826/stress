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
    <h2><?= h($location->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Isle') ?></h6>
            <p><?= h($location->isle) ?></p>
            <h6 class="subheader"><?= __('Shelf') ?></h6>
            <p><?= h($location->shelf) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($location->id) ?></p>
            <h6 class="subheader"><?= __('Seg') ?></h6>
            <p><?= $this->Number->format($location->seg) ?></p>
            <h6 class="subheader"><?= __('Box') ?></h6>
            <p><?= $this->Number->format($location->box) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Parts') ?></h4>
    <?php if (!empty($location->parts)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Manufact Id') ?></th>
            <th><?= __('Categ Id') ?></th>
            <th><?= __('Part Num') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Amt On Hand') ?></th>
            <th><?= __('Location Id') ?></th>
            <th><?= __('Active') ?></th>
            <th><?= __('Cc Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($location->parts as $parts): ?>
        <tr>
            <td><?= h($parts->id) ?></td>
            <td><?= h($parts->manufact_id) ?></td>
            <td><?= h($parts->categ_id) ?></td>
            <td><?= h($parts->part_num) ?></td>
            <td><?= h($parts->description) ?></td>
            <td><?= h($parts->amt_on_hand) ?></td>
            <td><?= h($parts->location_id) ?></td>
            <td><?= h($parts->active) ?></td>
            <td><?= h($parts->cc_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Parts', 'action' => 'view', $parts->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Parts', 'action' => 'edit', $parts->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Parts', 'action' => 'delete', $parts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parts->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
