<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $staff->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $staff->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Staffs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="staffs form large-10 medium-9 columns">
    <?= $this->Form->create($staff); ?>
    <fieldset>
        <legend><?= __('Edit Staff') ?></legend>
        <?php
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('email');
            echo $this->Form->input('active');
            echo $this->Form->hidden('address_id');
        ?>
    </fieldset>
    <fieldset>
        <legend><?= __('Edit Address') ?></legend>
        <?php
            echo $this->Form->input('address.street_address');
            echo $this->Form->input('address.city');
            echo $this->Form->input('address.zip_code', ['label' => 'Zip Code']);
            echo $this->Form->input('address.state');
            echo $this->Form->input('address.country');
            echo $this->Form->input('address.m_phone', ['label' => 'Mobile Phone']);
            echo $this->Form->input('address.f_phone', ['label' => 'Fax Phone']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>