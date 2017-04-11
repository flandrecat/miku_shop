<div class="cat_bd">
    <?php foreach ($models as $model):?>
        <div class="cat ">
            <h3><a href=""><?=$model->name?></h3>
            <div class="cat_detail">
                <dl class="dl_1st">
                    <?php foreach ($model->goodCategory as $sons):?>
                    <dt><a href=""><?=$sons->name?></a></dt>
                    <?php foreach ($sons->goodCategory as $son):?>
                        <dd>
                            <a href=""><?=$son->name?></a>
                        </dd>
                    <?php endforeach;?>
                </dl>
            </div>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>
</div>
