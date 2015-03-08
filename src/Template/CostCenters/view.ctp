<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Cost Center'), ['action' => 'edit', $costCenter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cost Center'), ['action' => 'delete', $costCenter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $costCenter->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cost Center'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="costCenters view col-lg-10 col-md-9 columns">
    <h2><?= h($costCenter->e_code) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('E Code') ?></h6>
                    <p><?= h($costCenter->e_code) ?></p>
                    <h6 class="subheader"><?= __('Description') ?></h6>
                    <p><?= h($costCenter->description) ?></p>
                    <h6 class="subheader"><?= __('Default Value') ?></h6>
                    <p><?= h($costCenter->default_value) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns numbers end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= $this->Number->format($costCenter->id) ?></p>
                    <h6 class="subheader"><?= __('Project Number') ?></h6>
                    <p><?= $this->Number->format($costCenter->project_number) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Active') ?></h6>
                    <p><?= $costCenter->active ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
