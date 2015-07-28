<div class="panel-group" id="accordion">
    <div class="panel panel-default" id="results-panel">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapse-results" href="#collapse-results">
            <h4 class="panel-title">
                Results
            </h4>
        </div>
        <div id="collapse-results" class="panel-collapse collapse">
            <div class="panel-body">
                <?php foreach($tables as $table => $items): ?>
                    <?php
                        $upper_table = $table;
                        if ($table == 'CostCenters') {
                            $table = 'cost_centers';
                        } else {
                            $table = strtolower($table);
                        }
                    ?>
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default results-panel" id="<?=$table?>-results-panel">
                            <div class="panel-heading" data-toggle="collapse" data-target="#collapse-<?=$table?>-results" href="#collapse-<?=$table?>-results">
                                <h4 class="panel-title">
                                    <?= ($table == 'cost_centers' ? 'Cost Centers' : ucwords($table)) ?>
                                </h4>
                            </div>
                            <div id="collapse-<?=$table?>-results" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?= $this->element('table', ['items' => $items]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>