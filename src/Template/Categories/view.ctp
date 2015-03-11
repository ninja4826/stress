<div class="actions columns col-lg-2 col-md-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="nav nav-stacked nav-pills">
        <li><?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Category'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'btn-danger']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="categories view col-lg-10 col-md-9 columns">
    <h2><?= h($category->category_name) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Category Name') ?></h6>
                    <p><?= h($category->category_name) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column col-lg-12">
        <h4 class="subheader"><?= __('Related Parts') ?></h4>
        <?php if(!empty($category->parts)): ?>
            <?= $this->element('table', ['items' => $category->parts, 'excluded_headers' => ['category']]) ?>
        <?php endif; ?>
    </div>
</div>