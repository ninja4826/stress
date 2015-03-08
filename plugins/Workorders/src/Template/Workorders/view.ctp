<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Workorder'), ['action' => 'edit', $workorder->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Workorder'), ['action' => 'delete', $workorder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workorder->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Workorders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Workorder'), ['action' => 'add']) ?> </li>
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
<div class="workorders view large-10 medium-9 columns">
    <h2><?= h($workorder->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <p><?= h($workorder->description) ?></p>
            <h6 class="subheader"><?= __('Location') ?></h6>
            <p><?= h($workorder->location) ?></p>
            <h6 class="subheader"><?= __('Est Time') ?></h6>
            <p><?= h($workorder->est_time) ?></p>
            <h6 class="subheader"><?= __('Wo Status') ?></h6>
            <p><?= $workorder->has('wo_status') ? $this->Html->link($workorder->wo_status->id, ['controller' => 'WoStatuses', 'action' => 'view', $workorder->wo_status->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Wo Type') ?></h6>
            <p><?= $workorder->has('wo_type') ? $this->Html->link($workorder->wo_type->id, ['controller' => 'WoTypes', 'action' => 'view', $workorder->wo_type->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Requestor') ?></h6>
            <p><?= $workorder->has('requestor') ? $this->Html->link($workorder->requestor->full_name, ['controller' => 'Staffs', 'action' => 'view', $workorder->requestor->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Wo Req') ?></h6>
            <p><?= h($workorder->wo_req) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($workorder->id) ?></p>
            <h6 class="subheader"><?= __('Fixed Price') ?></h6>
            <p><?= $this->Number->format($workorder->fixed_price) ?></p>
            <h6 class="subheader"><?= __('Project Number') ?></h6>
            <p><?= $this->Number->format($workorder->project_number) ?></p>
            <h6 class="subheader"><?= __('Pm Id') ?></h6>
            <p><?= $this->Number->format($workorder->pm_id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Date Received') ?></h6>
            <p><?= h($workorder->date_received) ?></p>
            <h6 class="subheader"><?= __('Date Required') ?></h6>
            <p><?= h($workorder->date_required) ?></p>
            <h6 class="subheader"><?= __('Date Signed') ?></h6>
            <p><?= h($workorder->date_signed) ?></p>
            <h6 class="subheader"><?= __('Date Promised') ?></h6>
            <p><?= h($workorder->date_promised) ?></p>
        </div>
        <div class="large-2 columns booleans end">
            <h6 class="subheader"><?= __('Expedite') ?></h6>
            <p><?= $workorder->expedite ? __('Yes') : __('No'); ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Permissions') ?></h4>
    <?php if (!empty($workorder->permissions)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Workorder Id') ?></th>
            <th><?= __('Can Edit') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($workorder->permissions as $permissions): ?>
        <tr>
            <td><?= h($permissions->id) ?></td>
            <td><?= h($permissions->user_id) ?></td>
            <td><?= h($permissions->workorder_id) ?></td>
            <td><?= h($permissions->can_edit) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Permissions', 'action' => 'view', $permissions->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Permissions', 'action' => 'edit', $permissions->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Permissions', 'action' => 'delete', $permissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permissions->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related WoTasks') ?></h4>
    <?php if (!empty($workorder->wo_tasks)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Workorder Id') ?></th>
            <th><?= __('Staff Id') ?></th>
            <th><?= __('Task Status Id') ?></th>
            <th><?= __('Task Id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($workorder->wo_tasks as $woTasks): ?>
        <tr>
            <td><?= h($woTasks->id) ?></td>
            <td><?= h($woTasks->workorder_id) ?></td>
            <td><?= h($woTasks->staff_id) ?></td>
            <td><?= h($woTasks->task_status_id) ?></td>
            <td><?= h($woTasks->task_id) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'WoTasks', 'action' => 'view', $woTasks->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'WoTasks', 'action' => 'edit', $woTasks->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'WoTasks', 'action' => 'delete', $woTasks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $woTasks->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related WoUpdateHistories') ?></h4>
    <?php if (!empty($workorder->wo_update_histories)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Workorder Id') ?></th>
            <th><?= __('Staff Id') ?></th>
            <th><?= __('Date Modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($workorder->wo_update_histories as $woUpdateHistories): ?>
        <tr>
            <td><?= h($woUpdateHistories->id) ?></td>
            <td><?= h($woUpdateHistories->workorder_id) ?></td>
            <td><?= h($woUpdateHistories->staff_id) ?></td>
            <td><?= h($woUpdateHistories->date_modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'WoUpdateHistories', 'action' => 'view', $woUpdateHistories->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'WoUpdateHistories', 'action' => 'edit', $woUpdateHistories->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'WoUpdateHistories', 'action' => 'delete', $woUpdateHistories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $woUpdateHistories->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
