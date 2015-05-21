<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Manufacturer'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Manufacturers'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="manufacturers index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <?= $this->element('table', ['items' => $manufacturers->toArray()]) ?>
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
