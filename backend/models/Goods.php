<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property string $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property string $goods_category_id
 * @property string $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $in_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static $status_name = ['1'=>'正常','0'=>'回收站'];
    public static $is_on_sale_name = ['1'=>'上架','0'=>'下架'];
    //public $log_img;

    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'logo', 'goods_category_id'], 'required'],
            [['goods_category_id', 'brand_id', 'stock', 'in_on_sale', 'status', 'sort', 'inputtime'], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['sn'], 'string', 'max' => 30],
            [['logo'], 'string', 'max' => 255],
/*            ['log_img','file','extensions'=>['jpg','png','gif'],
                'maxFiles' => 1,
                'skipOnEmpty'=>false],
        ];*/
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'logo' => '商品logo',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'shop_price' => '本店价格',
            'stock' => '库存',
            'in_on_sale' => '是否上架1是 0否',
            'status' => '1正常 0回收站',
            'sort' => '排序',
            'inputtime' => '录入时间',
           // 'log_img'=>'商品logo',
        ];
    }

    public static function getBrand()
    {
        $model = Brand::find()->asArray()->all();
        return ArrayHelper::map($model,'id','name');
    }

    public function getGoodsCategory()
    {
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }
    public function getBrandName()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    }

}
