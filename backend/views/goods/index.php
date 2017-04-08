<?php
echo '<h3>品牌表</h3>';
echo \yii\bootstrap\Html::a('增加',['goods/add'],['class'=>'btn btn-info']);
echo \yii\bootstrap\Html::a('回收站',['goods/del'],['class'=>'btn btn-warning']);
?>
<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method'=>'get',
    'action'=>yii\helpers\Url::to(['goods/index']),
    'options'=>['class'=>'form-inline'],
]);
echo $form->field($search,'name')->textInput(['placeholder'=>'商品名称'])->label(false);
echo $form->field($search,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo $form->field($search,'max_price')->textInput(['placeholder'=>'最高价格'])->label(false);
echo $form->field($search,'min_price')->textInput(['placeholder'=>'最低价格'])->label(false);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();
?>
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>商品名称</th>
            <th>货号</th>
            <th>LOGO</th>
            <th>商品分类</th>
            <th>品牌</th>
            <th>市场价格</th>
            <th>本店价格</th>
            <th>库存</th>
            <th>状态</th>
            <th>属性</th>
            <th>排序</th>
            <th>录入时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($goods as $good):?>
            <tr>
                <td><?=$good->id?></td>
                <td><?=$good->name?></td>
                <td><?=$good->sn?></td>
                <td><?=$good->logo?\yii\bootstrap\Html::img('@web'.$good->logo ,['width'=>30]):''?></td>
                <td><?=$good->goodsCategory->name?></td>
                <td><?=$good->brandName->name?></td>
                <td><?=$good->market_price?></td>
                <td><?=$good->shop_price?></td>
                <td><?=$good->stock?></td>
                <td><?=\backend\models\Goods::$status_name[$good->status]?></td>
                <td><?=\backend\models\Goods::$is_on_sale_name[$good->in_on_sale]?></td>
                <td><?=$good->sort?></td>
                <td><?=date('Y-m-d H:i:s',$good->inputtime)?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['goods/edit','id'=>$good->id],['class'=>'btn btn-success'])?>
                    <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$good->id],['class'=>'btn btn-danger'])?>
                    <?=\yii\bootstrap\Html::a('相册',['goods-gallery/index','id'=>$good->id],['class'=>'btn btn-info'])?></td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pages,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
