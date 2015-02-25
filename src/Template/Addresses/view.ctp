<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Address'), ['action' => 'edit', $address->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Address'), ['action' => 'delete', $address->id], ['confirm' => __('Are you sure you want to delete # {0}?', $address->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Addresses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Address'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="addresses view large-10 medium-9 columns">
    <h2><?= h($address->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
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
    </div>
</div>
