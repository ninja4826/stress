<?php
  $all_headers = [
    'Categories' => [
      'category_name' => 'Category Name'
    ],
    'CostCenters' => [
      'e_code' => 'E-Code',
      'description' => 'Description',
      'active' => 'Active',
      'default_value' => 'Default Value',
      'project_number' => 'Project Number'
    ],
    'Locations' => [
      'location_name' => 'Location Name'
    ],
    'Manufacturers' => [
      'manufacturer_name' => 'Name',
      'active' => 'Active'
    ],
    'Parts' => [
      'part_num' => 'Part Number',
      'location' => 'Location',
      'manufacturer' => 'Manufacturer',
      'category' => 'Category',
      'description' => 'Description',
      'amt_on_hand' => 'Amount on Hand',
      'active' => 'Active',
    ],
  ];
  
  $headers = $all_headers[$items[0]->table_name];
  
  if (!isset($excluded_headers)) {
    $excluded_headers = [];
  }
?>

<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <?php foreach($headers as $field => $header): ?>
          <?php if (!in_array($field, $excluded_headers)): ?>
            <th><?= $header ?></th>
          <?php endif; ?>
        <?php endforeach; ?>
          <?php
            if (!in_array('actions', $excluded_headers)) {
              echo '<th class="actions">Actions</th>';
            }
          ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <?php foreach(array_keys($headers) as $prop_name): ?>
            <?php if (!in_array($prop_name, $excluded_headers)): ?>
              <?php $prop = $item->$prop_name; ?>
              
              <?php if ($prop == $item->display_name): ?>
                
                <td><?= $this->Html->link($item->display_name, ['controller' => $item->table_name, 'action' => 'view', $item->id]) ?></td>
              
              <?php elseif (is_subclass_of($prop, 'App\\Model\\Entity\\AppEntity')): ?>
              
                <td><?= $this->Html->link($prop->display_name, ['controller' => $prop->table_name, 'action' => 'view', $prop->id]) ?></td>
                
              <?php elseif (gettype($prop) == 'boolean'): ?>
              
                <td><?= $prop ? __('Yes') : __('No') ?></td>
                
              <?php else: ?>
              
                <td><?= $prop ?></td>
                
              <?php endif; ?>
              
            <?php endif; ?>
          <?php endforeach; ?>
          <?php if (!in_array('actions', $excluded_headers)): ?>
            <td>
              <?= $this->Html->link('<span class="glyphicon glyphicon-pencil"></span><span class="sr-only">' . __('Edit') . '</span>', ['action' => 'edit', $item->id], ['escape' => false, 'class' => 'btn btn-xs btn-default', 'title' => __('Edit')]) ?>
              <?= $this->Form->postLink('<span class="glyphicon glyphicon-trash"></span><span class="sr-only">' . __('Delete') . '</span>', ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id), 'escape' => false, 'class' => 'btn btn-xs btn-danger', 'title' => __('Delete')]) ?>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>