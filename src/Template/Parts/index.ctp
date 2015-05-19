<!--<div id="test-div"></div>-->
<!--<div style="height=1000px;"></div>-->
<script>
    $(document).ready(function () {
        $('[data-toggle="offcanvas"]').click(function () {
            $('.row-offcanvas').toggleClass('active')
        });
    });
</script>
<div class="container">
    <div class="row-offcanvas row-offcanvas-left">
        <div class="parts index col-lg-10 col-md-9 columns pull-right">
            <p class="visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Actions</button>
            </p>
            <?php
                $parts_arr = $parts->toArray();
                unset($parts_arr['manufacturers']);
            ?>
            <?= $this->cell('Table::index', ['model' => 'Parts', 'alterations' => []])?>
        </div>
        <div class="sidebar-offcanvas actions col-lg-2 col-md-3 pull-left" id="sidebar">
            <div class="list-group">
                <?= $this->Html->link(__('New Part'), ['action' => 'add'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('List Parts'), ['action' => 'index'], ['class' => 'list-group-item active disabled']) ?>
                <?= $this->Html->link(__('List Manufacturers'), ['controller' => 'Manufacturers', 'action' => 'index'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('New Manufacturer'), ['controller' => 'Manufacturers', 'action' => 'add'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('List Locations'), ['controller' => 'Locations', 'action' => 'index'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('New Location'), ['controller' => 'Locations', 'action' => 'add'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('List Cost Centers'), ['controller' => 'CostCenters', 'action' => 'index'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('New Cost Center'), ['controller' => 'CostCenters', 'action' => 'add'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('List Part Vendors'), ['controller' => 'PartVendors', 'action' => 'index'], ['class' => 'list-group-item']) ?>
                <?= $this->Html->link(__('New Part Vendor'), ['controller' => 'PartVendors', 'action' => 'add'], ['class' => 'list-group-item']) ?>
            </div>
        </div>
    </div>
</div>