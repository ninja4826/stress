<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="vendors form large-10 medium-9 columns">
    <?= $this->Form->create($vendor); ?>
    <fieldset>
        <legend><?= __('Add Vendor') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('comment');
            echo $this->Form->input('website');
            echo $this->Form->input('email');
            echo $this->Form->input('active');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
