<?php
echo '<h4>商品相册</h4>';
echo '<hr/>';
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'goods_imgs[]')->fileInput(['multiple'=>true]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();