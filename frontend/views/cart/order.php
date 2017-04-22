<?php
$url = \yii\helpers\Url::to(['cart/success'])
?>
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><?=\yii\helpers\Html::img('@web/images/logo.png')?></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<form action="<?=$url?>" method="post" name="form1">
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息 <a href="javascript:;" id="address_modify"></a></h3>
            <div class="address_info">
                <?php foreach ($member_msgs as $member_msg):?>
                <p><input type="radio" value="<?=$member_msg->id?>" name="address_id"/><?=$member_msg->name.'   '.$member_msg->tel.'    '.$member_msg->cmbProvince.'    '.$member_msg->cmbCity.'    '.$member_msg->cmbArea.'    '.$member_msg->address?></p>
                <?php endforeach;?>
            </div>
        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery_select">
        <table>
            <thead>
            <tr>
                <th class="col1">送货方式</th>
                <th class="col2">运费</th>
                <th class="col3">运费标准</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($deliverys as $k=>$delivery):?>
            <tr class="">
                <td>
                    <input type="radio" name="delivery_id" value="<?=$k?>" checked="checked" /><?=$delivery["delivery_name"]?>
                </td>
                <td><?=$delivery["delivery_price"]?></td>
                <td><?=$delivery["delivery_info"]?></td>
            </tr>
            <?php endforeach;?>

            </tbody>
        </table>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 <a href="javascript:;" id="pay_modify"></a></h3>
                <table>
                    <?php foreach ($pays as $k=>$pay):?>
                    <tr class="cur">
                        <td class="col1"><input type="radio" value="<?=$k?>" name="pay_id" /><?=$pay['pay_type_name']?></td>
                        <td class="col2"><?=$pay['pay_info']?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </div>
     <!-- 支付方式  end-->


        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($goods as $good):?>
                    <tr>
                        <td class="col1"><a href=""><?=\yii\helpers\Html::img(Yii::$app->params['picUrl'].$good['logo'])?></a>  <strong><a href=""><?=$good['name']?></a></strong></td>
                        <td class="col3">￥<?=$good['shop_price']?></td>
                        <td class="col4"> <?=$good['amount']?></td>
                        <td class="col5"><span>￥<?=$good['shop_price']*$good['amount']?></span></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span>4 件商品，总商品金额：</span>
                                <em>￥5316.00</em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em>-￥240.00</em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em>￥10.00</em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥5076.00</em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>

    <div class="fillin_ft">
        <a href="javascript:document.form1.submit()"><span>提交订单</span></a>
        <p>应付总额：<strong>￥5076.00元</strong></p>
    </div>
</form>
</div>