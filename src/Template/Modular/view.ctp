<?php $this->assign('title', $object->display_name); ?>
<div class="view col-lg-12 col-md-9 columns">
    <h1 class="pull-left"><?=$object->display_name?></h1>
    <?php foreach($info['fields'] as $name => $field): ?>
        <div class="row">
            <h6 class="subheader"><?= __($field['label']) ?></h6>
            <p><?=$object[$name]?></p>
        </div>
    <?php endforeach; ?>
</div>