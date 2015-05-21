<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id]) ?> </li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $vendor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id), 'class' => 'btn-danger']
            )
        ?></li>
        <li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="vendors form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($vendor); ?>
    <fieldset>
        <legend><?= __('Edit Vendor') ?></legend>
        <?php
            echo $this->Form->input('vendor_name');
            echo $this->Form->input('comment');
            echo $this->Form->input('website');
            echo $this->Form->input('email');
            echo $this->Form->input('active');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
