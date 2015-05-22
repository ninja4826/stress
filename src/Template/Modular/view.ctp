<?php $this->assign('title', $object->display_name); ?>
<!--<?= debug($info) ?>-->
<div class="view col-lg-12 col-md-9 columns">
    <h1 class="pull-left"></h1>
    <?php
        $assocs = [];
        $general = [];
        foreach($info['fields'] as $name => $field) {
            if (array_key_exists('assoc', $field)) {
                $assocs[$name] = $field;
            } else {
                $general[$name] = $field;
                $this->append('table_header', '<th>'.$field['label'].'</th>');
                $val = $object[$name];
                if ($field['type'] == 'checkbox') {
                    $val = ($object[$name] ? 'Yes' : 'No');
                }
                $this->append('table_data', '<td>'.$val.'</td>');
            }
        }
    ?>
    <!-- Object properties -->
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?=$object->display_name?>
                </h3>
            </div>
            <table class="table">
                <thead>
                    <?=$this->fetch('table_header')?>
                </thead>
                <tbody>
                    <?=$this->fetch('table_data')?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a data-toggle="collapse" data-target="#assoc-panel">
                        <?=h('Associated Objects')?>
                    </a>
                </h3>
            </div>
            <div id="assoc-panel" class="panel-collapse collapse in">
                <div class="panel-body">
                    <?php foreach($assocs as $name => $field): ?>
                        <?php
                            $this->assign('table_header', '');
                            $this->assign('table_data', '');
                            
                            $object_ = $object[$name];
                            $count = 0;
                            foreach($field['assoc']['info']['fields'] as $name_ => $field_) {
                                if (!array_key_exists('assoc', $field_)) {
                                    $this->append('table_header', '<th>'.$field_['label'].'</th>');
                                    $count++;
                                    $val = $object_[$name_];
                                    if ($field_['type'] == 'checkbox') {
                                        $val = ($object_[$name_] ? 'Yes' : 'No');
                                    }
                                    if (array_key_exists('display_field', $field_) && $field_['display_field']) {
                                        $this->append('table_data', '<td><a href="'.$field_['url'].'/'.$object_['id'].'">'.$val.'</a></td>');
                                    } else {
                                        $this->append('table_data', '<td>'.$val.'</td>');
                                    }
                                }
                            }
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a data-toggle="collapse" data-target="#<?=$name?>-panel" class="collapsed">
                                        <?=h($field['label'])?>
                                    </a>
                                </h3>
                            </div>
                            <div id="<?=$name?>-panel" class="panel-collapse collapse">
                                <table class="table">
                                    <thead>
                                        <?= $this->fetch('table_header') ?>
                                    </thead>
                                    <tbody>
                                        <?= $this->fetch('table_data') ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        console.log(JSON.parse('<?=json_encode($info)?>'));
    });
</script>