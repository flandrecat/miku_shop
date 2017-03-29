<?php
echo '<div class=""><h4>文章分类</h4></div>';
echo \yii\bootstrap\Html::a('增加分类',['acticle-category/add'],['class'=>'btn btn-info']);
?>
<table class="table">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否是帮助相关分类</th>
        <th>操作</th>
    </tr>
    <?php foreach ($acticles as $acticle):?>
        <tr>
            <td><?=$acticle->id?></td>
            <td><?=$acticle->name?></td>
            <td><?=$acticle->intro?></td>
            <td><?=\backend\models\ActicleCategory::$status_name[$acticle->status]?></td>
            <td><?=$acticle->sort?></td>
            <td><?=\backend\models\ActicleCategory::$is_help_name[$acticle->is_help]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['acticle-category/edit','id'=>$acticle->id],['class'=>'btn btn-success']) ?>
                <?=\yii\bootstrap\Html::a('删除',['acticle-category/delete','id'=>$acticle->id],['class'=>'btn btn-danger']) ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
   'pagination' => $pages,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页',
]);


