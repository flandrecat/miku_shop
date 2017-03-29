<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'acticle_category_id')->dropDownList(\backend\models\Acticle::getActicleCategoryOptions());
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Acticle::$status_name);
echo $form->field($model,'sort');
echo $form->field($details,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();