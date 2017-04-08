<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加权限',['permission/add'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($permissions as $permission):?>
        <tr>
            <td><?=$permission->name?></td>
            <td><?=$permission->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['permission/delete','name'=>$permission->name],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>