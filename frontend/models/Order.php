<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province_name
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property string $tel
 * @property string $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property string $pay_type_id
 * @property string $pay_type_name
 * @property string $price
 * @property integer $status
 * @property string $trade_no
 * @property string $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static $delivery = [
        1=>[ 'delivery_name'=>'顺丰','delivery_price'=>'20','delivery_info'=>'速度非常快,服务好'],
        2=>[ 'delivery_name'=>'圆通','delivery_price'=>'15','delivery_info'=>'速度快,服务一般'],
        3=>[ 'delivery_name'=>'申通','delivery_price'=>'15','delivery_info'=>'速度一般,服务一般'],
    ];

    public static $pay = [
        1=>[ 'pay_type_name'=>'货到付款','pay_info'=>'送货上门后再收款，支持现金、POS机刷卡、支票支付,服务好'],
        2=>[ 'pay_type_name'=>'在线支付','pay_info'=>'即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        3=>[ 'pay_type_name'=>'上门自提	','pay_info'=>'自提时付款，支持现金、POS刷卡、支票支付'],
        4=>[ 'pay_type_name'=>'邮局汇  款','pay_info'=>'通过快钱平台收款 汇款后1-3个工作日到账'],
    ];

    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'pay_type_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name', 'province_name', 'city_name', 'area_name', 'detail_address', 'delivery_name', 'pay_type_name', 'trade_no'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'name' => '收货人',
            'province_name' => '省份',
            'city_name' => '城市',
            'area_name' => '区县',
            'detail_address' => '详细地址',
            'tel' => '手机号码',
            'delivery_id' => '配送方式ID',
            'delivery_name' => '配送方式的名字',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式',
            'pay_type_name' => '支付方式的名称',
            'price' => '商品金额',
            'status' => '订单状态 0取消 1等待付款 2待发货 3待收货 4完成',
            'trade_no' => '第三方支付交易号',
            'create_time' => '创建时间',
        ];
    }
}
