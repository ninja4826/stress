<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $workorder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $workorder->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Workorders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wo Statuses'), ['controller' => 'WoStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Status'), ['controller' => 'WoStatuses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wo Types'), ['controller' => 'WoTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Type'), ['controller' => 'WoTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Staffs'), ['controller' => 'Staffs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Staff'), ['controller' => 'Staffs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Permissions'), ['controller' => 'Permissions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permission'), ['controller' => 'Permissions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wo Tasks'), ['controller' => 'WoTasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Task'), ['controller' => 'WoTasks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wo Update Histories'), ['controller' => 'WoUpdateHistories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wo Update History'), ['controller' => 'WoUpdateHistories', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="workorders form large-10 medium-9 columns">
    <?= $this->Form->create($workorder); ?>
    <fieldset>
        <legend><?= __('Edit Workorder') ?></legend>
        <?php
            echo $this->Form->input('date_received');
            echo $this->Form->input('date_required');
            echo $this->Form->input('expedite');
            echo $this->Form->input('description');
            echo $this->Form->input('location');
            echo $this->Form->input('date_signed');
            echo $this->Form->input('fixed_price');
            echo $this->Form->input('date_promised');
            echo $this->Form->input('est_time');
            echo $this->Form->input('wo_status_id', ['options' => $woStatuses]);
            echo $this->Form->input('wo_type_id', ['options' => $woTypes]);
            echo $this->Form->input('project_number');
            echo $this->Form->input('pm_id');
            echo $this->Form->input('req_id', ['options' => $staffs]);
            echo $this->Form->input('wo_req');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
