<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Cost Center'), ['action' => 'edit', $costCenter->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $costCenter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $costCenter->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Cost Center'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="costCenters form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($costCenter); ?>
    <fieldset>
        <legend><?= __('Edit Cost Center') ?></legend>
        <?php
            echo $this->Form->input('e_code');
            echo $this->Form->input('description');
            echo $this->Form->input('active');
            echo $this->Form->input('default_value');
            echo $this->Form->input('project_number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
