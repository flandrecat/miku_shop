<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username')->textInput(['placeholder'=>'用户名/邮箱']);
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'remember')->checkbox();
echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-success']);
echo \yii\bootstrap\Html::a('注册',['admin/add'],['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();