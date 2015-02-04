<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Cost Centers'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="costCenters form large-10 medium-9 columns">
    <?= $this->Form->create($costCenter); ?>
    <fieldset>
        <legend><?= __('Add Cost Center') ?></legend>
        <?php
            echo $this->Form->input('e_code');
            echo $this->Form->input('description');
            echo $this->Form->input('active');
            echo $this->Form->input('def');
            echo $this->Form->input('project_number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
