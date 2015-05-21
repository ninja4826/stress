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
    <div class="parts index col-lg-12 col-md-9 columns">
        <?php
            $parts_arr = $parts->toArray();
            unset($parts_arr['manufacturers']);
        ?>
        
        <?= $this->cell('Table::index', ['model' => 'Parts', 'alterations' => []]) ?>
    </div>
</div>