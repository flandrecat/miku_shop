<?php
/** @var $this yii\web\View  */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <dl>
            <dt>1.许坤 北京市 昌平区 仙人跳区 仙人跳大街 17002810530 </dt>
            <dd>
                <a href="">修改</a>
                <a href="">删除</a>
                <a href="">设为默认地址</a>
        </dd>
        </dl>
        <dl class="last"> <!-- 最后一个dl 加类last -->
            <dt>2.许坤 四川省 成都市 高新区 仙人跳大街 17002810530 </dt>
            <dd>
                <a href="">修改</a>
                <a href="">删除</a>
                <a href="">设为默认地址</a>
            </dd>
        </dl>

    </div>

    <div class="address_bd mt10">
        <h4>新增收货地址</h4>
        <?php $this->registerCss('li.required label:before{content:"* ";color:red;}');?>
        <?php $form = ActiveForm::begin();?>
        <?php /** @var $address  */?>
        <ul>
            <?php
            $formStyle = [
                'options'=>['tag'=>'li'],
                'template'=> "{label}\n{input}\n{hint}\n{error}",
                'errorOptions'=>['tag'=>'div','style'=>'color:red'],
            ];?>

            <?=$form->field($model,'name')->textInput(['class'=>'txt',]);?>
            <li>
                <label for=""><span>*</span>所在地区：</label>
                <select name="Address[cmbProvince]" id="cmbProvince">

                </select>
                <select name="Address[cmbCity]" id="cmbCity">

                </select>
                <select name="Address[cmbArea]" id="cmbArea">

                </select>
            </li>
            <?=$form->field($model,'address')->textInput(['class'=>'txt'])?>
            <?=$form->field($model,'tel')->textInput(['class'=>'txt'])?>

            <li>
                <label>&nbsp;</label>
                    <input class="check" name="Address[status]" value="1" type="checkbox">
                设为默认地址
                <p style="color:red"></p>
            </li>
            <li>
                <label>&nbsp;</label>
                <?=Html::submitInput('保存',['class'=>'btn'])?>
            </li>
        </ul>
        <?php ActiveForm::end();?>

    </div>

</div>
<script type="text/javascript">
    addressInit('cmbProvince', 'cmbCity', 'cmbArea', '四川', '请选择', '请选择');
</script>
