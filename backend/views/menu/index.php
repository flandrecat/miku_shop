<?php
echo \yii\bootstrap\Html::a('添加菜单',['menu/add'],['class'=>'btn btn-info']);
?>
<table class="table table-bordered">
    <tr>
        <th>名称</th>
        <th>路由</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):?>
        <tr>
            <td><?=str_repeat('—',$model->depth).$model->name?></td>
            <td><?=$model->url?></td>
            <td><?=$model->intro?></td>
            <td>
                <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$model->id],['class'=>'btn btn-success'])?>
                <?=\yii\bootstrap\Html::a('删除',['menu/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
            </td>
        </tr>
        <?php  foreach ($model->menus as $child):?>
            <tr>
                <td><?=str_repeat('—',$child->depth).$child->name?></td>
                <td><?=$child->url?></td>
                <td><?=$child->intro?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['menu/edit','id'=>$child->id],['class'=>'btn btn-success'])?>
                    <?=\yii\bootstrap\Html::a('删除',['menu/delete','id'=>$child->id],['class'=>'btn btn-danger'])?>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endforeach;?>
</table>