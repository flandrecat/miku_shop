<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加文章',['acticle/add'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>文章名称</th>
        <th>文章分类</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>录入时间</th>
        <th>文章类容</th>
        <th>操作</th>
    </tr>
    <?php foreach ($acticles as $acticle):?>
        <tr>
            <td><?=$acticle->id?></td>
            <td><?=$acticle->name?></td>
            <td><?=$acticle->acticleCategory->name?></td>
            <td><?=$acticle->intro?></td>
            <td><?=\backend\models\Acticle::$status_name[$acticle->status]?></td>
            <td><?=$acticle->sort?></td>
            <td><?=date('Y-m-d H:i:s',$acticle->inputtime)?></td>
            <td></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['acticle/edit','id'=>$acticle->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['acticle/delete','id'=>$acticle->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
echo \yii\widgets\LinkPager::widget([
   'pagination'=>$pages,
    'nextPageLabel'=> '上一页 ',
    'prevPageLabel'=> '下一页',
]);