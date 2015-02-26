<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= debug($this->request->session()->read('Redirect.last_page')) ?></li>
        <li><?= $this->Html->link(__('Edit Staff'), ['action' => 'edit', $staff->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Staff'), ['action' => 'delete', $staff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $staff->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Staffs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Staff'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="staffs view large-10 medium-9 columns">
    <h2><?= h($staff->first_name . ' ' . $staff->last_name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Email') ?></h6>
            <p><?= h($staff->email) ?></p>
            <h6 class="subheader"><?= __('Active') ?></h6>
            <p><?= $staff->active ? __('Yes') : __('No'); ?></p>
            <?php if (!$staff->user): ?>
                <h6 class="subheader">
                    <?= $this->Html->link(__('Create a user for this staff member.'), [
                        'controller' => 'Users',
                        'action' => 'add',
                        '?' => ['staff' => $staff->id]
                    ]) ?>
                </h6>
            <?php else: ?>
                <h6 class="subheader">
                    <?= $this->Html->link(__('User account of staff member.'), [
                        'controller' => 'Users',
                        'action' => 'view',
                        $staff->user->id
                    ]) ?>
                </h6>
            <?php endif; ?>
        </div>
        <?php if ($staff->address): ?>
            <?php $address = $staff->address; ?>
            <div class="large-5 columns strings">
                <legend><?= $this->Html->link(__('Address'), ['controller' => 'Addresses', 'action' => 'view', $staff->address->id]) ?></legend>
                <h6 class="subheader"><?= __('Street Address') ?></h6>
                <p><?= h($address->street_address) ?></p>
                <h6 class="subheader"><?= __('City') ?></h6>
                <p><?= h($address->city) ?></p>
                <h6 class="subheader"><?= __('Zip Code') ?></h6>
                <p><?= h($address->zip_code) ?></p>
                <h6 class="subheader"><?= __('State') ?></h6>
                <p><?= h($address->state) ?></p>
                <h6 class="subheader"><?= __('Country') ?></h6>
                <p><?= h($address->country) ?></p>
                <?php if ($address->m_phone): ?>
                    <h6 class="subheader"><?= __('Mobile Phone') ?></h6>
                    <p><?= h($address->m_phone) ?></p>
                <?php endif; ?>
                <?php if ($address->f_phone): ?>
                    <h6 class="subheader"><?= __('Fax') ?></h6>
                    <p><?= h($address->f_phone) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>