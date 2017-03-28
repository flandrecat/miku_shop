<?php
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\ActicleCategory::$status_name);
echo $form->field($model,'sort');
echo $form->field($model,'is_help',['inline'=>true])->radioList(\backend\models\ActicleCategory::$is_help_name);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();