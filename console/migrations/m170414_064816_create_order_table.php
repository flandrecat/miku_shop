<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170414_064816_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('会员ID'),
            'name'=>$this->string()->comment('收货人'),
            'province_name'=>$this->string()->comment('省份'),
            'city_name'=>$this->string()->comment('城市'),
            'area_name'=>$this->string()->comment('区县'),
            'detail_address'=>$this->string()->comment('详细地址'),
            'tel'=>$this->char(11)->comment('手机号码'),
            'delivery_id'=>$this->integer()->unsigned()->comment('配送方式ID'),
            'delivery_name'=>$this->string()->comment('配送方式的名字'),
            'delivery_price'=>$this->decimal(7,2)->comment('运费'),
            'pay_type_id'=>$this->integer()->unsigned()->comment('支付方式'),
            'pay_type_name'=>$this->string()->comment('支付方式的名称'),
            'price'=>$this->decimal(10,2)->comment('商品金额'),
            'status'=>$this->integer(2)->comment('订单状态 0取消 1等待付款 2待发货 3待收货 4完成'),
            'trade_no'=>$this->string()->comment('第三方支付交易号'),
            'create_time'=>$this->integer()->unsigned()->comment('创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
