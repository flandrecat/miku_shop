<?php
use yii\web\JsExpression;
use yii\bootstrap\Html;
use xj\uploadify\Uploadify;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
//echo $form->field($model,'logo_img')->fileInput();
echo $form->field($model,'logo')->hiddenInput();
//显示
echo Html::img($model->logo,['id'=>'img','width'=>'100']);
//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 30,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        //console.log(data.fileUrl);
        $("#brand-logo").val(data.fileUrl);
        $("#img").attr("src",data.fileUrl);
    }
}
EOF
        ),
    ]
]);
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::$status_name);
/*echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>'
]);*/
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

