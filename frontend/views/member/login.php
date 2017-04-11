<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
    <div class="login_hd">
        <h2>用户登录</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form = \yii\widgets\ActiveForm::begin();
            echo '<ul>';
            echo $form->field($model,'username',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}:\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->textInput(['class'=>'txt','placeholder'=>'用户名/邮箱']);

            echo $form->field($model,'password',
                [
                    'options'=>['tag'=>'li'],//包裹整个输入框的标签
                    'errorOptions'=>['tag'=>'p'],//错误信息的标签
                    'template'=>"{label}:\n{input}\n{hint}\n{error}",//输出模板
                ]
            )->passwordInput(['class'=>'txt','placeholder'=>'密码']);
            echo '<li><div class="">'.$form->field($model,'remember')->checkbox().'</div></li>';

            echo '<li><label for="">&nbsp;</label>'.\yii\helpers\Html::submitButton('',['class'=>'login_btn']).'</li>';
            //echo \yii\bootstrap\Html::submitButton('登录',['class'=>'btn btn-success']);
            //echo \yii\bootstrap\Html::a('注册',['member/register'],['class'=>'btn btn-info']);
            echo '</ul>';
            \yii\widgets\ActiveForm::end();
            ?>
        </div>
        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>
    </div>
</div>
