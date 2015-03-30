<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('New Cost Center'), ['action' => 'add']) ?></li>
        <li class="active disabled"><?= $this->Html->link(__('List Cost Centers'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="costCenters index col-lg-10 col-md-9 columns">
    <div class="table-responsive">
        <?= $this->element('table', ['items' => $costCenters->toArray()]) ?>
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
