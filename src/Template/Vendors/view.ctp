<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vendor'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="vendors view col-lg-10 col-md-9 columns">
    <h2><?= h($vendor->id) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Vendor Name') ?></h6>
                    <p><?= h($vendor->vendor_name) ?></p>
                    <h6 class="subheader"><?= __('Comment') ?></h6>
                    <p><?= h($vendor->comment) ?></p>
                    <h6 class="subheader"><?= __('Website') ?></h6>
                    <p><?= h($vendor->website) ?></p>
                    <h6 class="subheader"><?= __('Email') ?></h6>
                    <p><?= h($vendor->email) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($vendor->id) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Active') ?></h6>
                    <p><?= $vendor->active ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
