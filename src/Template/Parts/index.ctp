<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Part'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Parts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['controller' => 'Manufacturers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manufacturer'), ['controller' => 'Manufacturers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['controller' => 'CostCenters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cost Center'), ['controller' => 'CostCenters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="parts index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th><?= __('Part Number') ?></th>
                <th><?= $this->Paginator->sort('location_id') ?></th>
                <th><?= $this->Paginator->sort('manufacturer_id') ?></th>
                <th><?= $this->Paginator->sort('category_id') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= __('Amount on Hand') ?></th>
                <th><?= $this->Paginator->sort('active') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($parts as $part): ?>
            <tr>
                <td><?= $this->Html->link($part->part_num, ['action' => 'view', $part->id]) ?></td>
                <td>
                    <?= $part->has('location') ? $this->Html->link($part->location->location_name, ['controller' => 'Locations', 'action' => 'view', $part->location_id]) : '' ?>
                </td>
                <td>
                    <?= $part->has('manufacturer') ? $this->Html->link($part->manufacturer->manufacturer_name, ['controller' => 'Manufacturers', 'action' => 'view', $part->manufacturer->id]) : '' ?>
                </td>
                <td>
                    <?= $part->has('category') ? $this->Html->link($part->category->category_name, ['controller' => 'Categories', 'action' => 'view', $part->category->id]) : '' ?>
                </td>
                <td><?= h($part->description) ?></td>
                <td><?= $this->Number->format($part->amt_on_hand) ?></td>
                <td><?= $part->active ? __('Yes') : __('No') ?></td>
                <td class="actions">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $part->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
                    <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $part->id], ['confirm' => __('Are you sure you want to delete # {0}?', $part->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>