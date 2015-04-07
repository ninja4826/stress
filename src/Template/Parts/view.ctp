<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Part'), ['action' => 'edit', $part->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Part'), ['action' => 'delete', $part->id], ['confirm' => __('Are you sure you want to delete # {0}?', $part->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Parts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part'), ['action' => 'add']) ?> </li>
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
<div class="parts view col-lg-10 col-md-9 columns">
    <h2><?= h($part->part_num) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Part Num') ?></h6>
                    <p><?= h($part->part_num) ?></p>
                    <h6 class="subheader"><?= __('Description') ?></h6>
                    <p><?= h($part->description) ?></p>
                    <h6 class="subheader"><?= __('Manufacturer') ?></h6>
                    <p><?= $part->has('manufacturer') ? $this->Html->link($part->manufacturer->manufacturer_name, ['controller' => 'Manufacturers', 'action' => 'view', $part->manufacturer->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Category') ?></h6>
                    <p><?= $part->has('category') ? $this->Html->link($part->category->category_name, ['controller' => 'Categories', 'action' => 'view', $part->category->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Cost Center') ?></h6>
                    <p><?= $part->has('cost_center') ? $this->Html->link($part->cost_center->e_code, ['controller' => 'CostCenters', 'action' => 'view', $part->cost_center->id]) : '' ?></p>
                    <h6 class="subheader"><?= __('Location') ?></h6>
                    <p><?= $part->has('location') ? $this->Html->link($part->location->location_name, ['controller' => 'Locations', 'action' => 'view', $part->location->id]) : '' ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($part->id) ?></p>
                    <h6 class="subheader"><?= __('Amt On Hand') ?></h6>
                    <p><?= $this->Number->format($part->amt_on_hand) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Active') ?></h6>
                    <p><?= $part->active ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div role="tabpanel" id="related-panel">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#partVendor-related" aria-controls="partVendor-related" role="tab" data-toggle="tab">Part Vendors</a>
                </li>
                <li role="presentation">
                    <a href="#transaction-form" aria-controls="transaction-form" role="tab" data-toggle="tab">Add Transaction</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                    <div role="tabpanel" class="tab-pane active" id="partVendor-related">
                        <div class="well well-sm">
                            <div class="table-responsive">
                                <?= $this->element('table', ['items' => $part->part_vendors]) ?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="transaction-form">
                        <div class="well well-sm">
                            <span>
                                <p>second</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>