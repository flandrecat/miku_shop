<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput(['placeholder'=>'用户名/邮箱']);
echo $form->field($model,'password')->passwordInput();
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();