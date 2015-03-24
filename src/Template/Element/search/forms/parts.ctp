<div class="row">
    <div class="col-lg-9">
        <div class="input-group">
            <label for="part-test"></label>
            <span class="input-group-btn">
                <select class="btn">
                    <option>Part Number</option>
                    <option>Description</option>
                </select>
            </span>
            <span class="input-group-btn">
                <span class="btn">is</span>
            </span>
            <span class="input-group-btn">
                <select class="btn">
                    <option>like</option>
                    <option>equal to</option>
                </select>
            </span>
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <button class="btn btn-success btn-add" type="button">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </span>
        </div>
    </div>
</div>

<!--<div class="panel-group" id="accordion">-->
                <!--    <div class="panel panel-default" id="<?=$form?>-panel">-->
                <!--        <div class="panel-heading">-->
                <!--            <h4 class="panel-title">-->
                <!--                <a data-toggle="collapse" data-target="#collapse-<?=$form?>" href="#collapse-<?=$form?>">-->
                <!--                    <?= ucwords(str_replace("_", " ", $form)) ?>-->
                <!--                </a>-->
                <!--            </h4>-->
                <!--        </div>-->
                <!--        <div id="collapse-<?=$form?>" class="panel-collapse collapse in">-->
                <!--            <div class="panel-body">-->
                <!--                <div class="<?=$form?> form col-lg-10 col-md-9 columns">-->
                <!--                    <form method="post" accept-charset="utf-8" class="<?=$form?>-form" action="/search">-->
                <!--                        <div style="display:none;">-->
                <!--                            <input type="hidden" name="_method" value="POST">-->
                <!--                        </div>-->
                <!--                        <fieldset>-->
                <!--                            <?= $this->element('search/forms/'.$form) ?>-->
                <!--                        </fieldset>-->
                <!--                    </form>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->