<?php
echo '<h4>商品相册</h4>';
echo '<hr/>';
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'img_file[]')->fileInput(['multiple'=>true]);
/*echo $form->field($model,'path')->hiddenInput();
//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 30,
        'onUploadError' => new \yii\web\JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new \yii\web\JsExpression(<<<JS
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        //console.log(data);
        $("#goodsgallery-path").val(data.fileUrl);    
        $("#img").attr("src",data.fileUrl);
    }
}
JS
        ),
    ]
]);
//显示
echo \yii\bootstrap\Html::img($model->path,['id'=>'img','width'=>'100']);
echo '<div class="box">
            
</div>';

echo '<br/>';
echo '<br/>';
echo '<br/>';*/
echo '<div>'.\yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']).'</div>';
\yii\bootstrap\ActiveForm::end();
