<?php
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
    <?php foreach ($model as $mode):?>
        <tr>
            <td><?=$mode->id?></td>
            <td><?=$mode->name?></td>
            <td><?=$mode->intro?></td>
            <td><?=\backend\models\ActicleCategory::$status_name[$mode->status]?></td>
            <td><?=$mode->sort?></td>
            <td><?=\backend\models\ActicleCategory::$is_help_name[$mode->is_help]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['acticle-category/edit','id'=>$mode->id],['class'=>'btn btn-success']) ?>
                <?=\yii\bootstrap\Html::a('删除',['acticle-category/delete','id'=>$mode->id],['class'=>'btn btn-danger']) ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
