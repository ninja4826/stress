<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Cost Center'), ['action' => 'edit', $costCenter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cost Center'), ['action' => 'delete', $costCenter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $costCenter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cost Center'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="costCenters view large-10 medium-9 columns">
    <h2><?= h($costCenter->e_code) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($costCenter->description) ?></p>
            <h6 class="subheader"><?= __('Default Value') ?></h6>
            <p><?= h($costCenter->default_value) ?></p>
            <h6 class="subheader"><?= __('Project Number') ?></h6>
            <p><?= h($costCenter->project_number) ?></p>
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $costCenter->active ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
