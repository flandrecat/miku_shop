<?php
echo \yii\bootstrap\Html::a('新增图片',['goods-gallery/add?id='.$id],['class'=>'btn btn-info']);
/* @var $this yii\web\View */
echo \yii\bootstrap\Html::a('返回',['goods/index'],['class'=>'btn btn-info']);
echo '<br/>';
echo '<br/>';
?>
<?php foreach ($models as $model):?>
<div>
    <?=$model->path?\yii\bootstrap\Html::img('@web/'.$model->path ,['width'=>100]):''?>
    <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$model->id],['class'=>'btn btn-danger'])?>
    <?=\yii\bootstrap\Html::a('编辑',['goods-gallery/edit','id'=>$model->id],['class'=>'btn btn-success'])?>

</div>
    <br/>
    <br/>
<?php endforeach;?>