<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Manufacturer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="manufacturers form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($manufacturer); ?>
    <fieldset>
        <legend><?= __('Add Manufacturer') ?></legend>
        <?php
            echo $this->Form->input('manufacturer_name');
            echo $this->Form->input('active');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
