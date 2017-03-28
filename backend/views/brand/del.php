<?php
echo \yii\bootstrap\Html::a('品牌首页',['brand/index'],['class'=>'btn btn-info']);
?>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>品牌名称</th>
            <th>简介</th>
            <th>LOGO</th>
            <th>排序</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($brands as $brand):?>
            <tr>
                <td><?=$brand->id?></td>
                <td><?=$brand->name?></td>
                <td><?=$brand->intro?></td>
                <td><?=$brand->logo?\yii\bootstrap\Html::img('@web'.$brand->logo ,['width'=>30]):''?></td>
                <td><?=$brand->sort?></td>
                <td><?=\backend\models\Brand::$status_name[$brand->status]?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['brand/edit','id'=>$brand->id],['class'=>'btn btn-success'])?>
                    <?=\yii\bootstrap\Html::a('彻底删除',['brand/deletes','id'=>$brand->id],['class'=>'btn btn-danger'])?></td>
            </tr>
        <?php endforeach;?>
    </table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pages,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);
