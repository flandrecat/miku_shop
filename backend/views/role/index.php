<?php
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('添加角色',['role/add'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($roles as $role):?>
        <tr>
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['role/edit','name'=>$role->name],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['role/delete','name'=>$role->name],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>