<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li class="active disabled"><?= $this->Html->link(__('New Part'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Manufacturers'), ['controller' => 'Manufacturers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Manufacturer'), ['controller' => 'Manufacturers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cost Centers'), ['controller' => 'CostCenters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cost Center'), ['controller' => 'CostCenters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="parts form col-lg-10 col-md-9 columns">
    <?= $this->Form->create($part, ['class' => 'part-form']); ?>
    <fieldset>
        <legend><?= __('Add Part') ?></legend>
        <?php
            echo $this->Form->input('part_num');
            echo $this->Form->input('description');
            echo $this->Form->input('amt_on_hand');
            echo $this->Form->input('active');
            echo $this->Form->input('location_name', ['type' => 'text', 'required' => true]);
            echo $this->Form->input('manufacturer_id', ['options' => $manufacturers]);
            echo $this->Form->input('category_id', ['options' => $categories]);
            echo $this->Form->input('cc_id', ['options' => $costCenters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success form-submit-btn']) ?>
    <?= $this->Form->end() ?>
</div>
<script>
    var json = JSON.parse('<?= json_encode($allParts); ?>');
    $(".form-submit-btn").click(function( event ) {
        event.preventDefault();
        if ($.inArray($('#part-num').val(), json) >= 0)
        {
            if (confirm("Part already exists. Would you like to add this quantity to the existing part? Note: The existing part's location will be used."))
            {
                $(".part-form").submit();
            } else {
                window.location = "/";
            }
        } else {
            $(".part-form").submit();
        }
    });
</script>