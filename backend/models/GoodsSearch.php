<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/3
 * Time: 14:08
 */

namespace backend\models;


use yii\base\Model;
use yii\db\ActiveQuery;

class GoodsSearch extends Model
{
    public $name;
    public $sn;
    public $max_price;
    public $min_price;

    public function rules()
    {
        return[
          ['name','string'],
          ['sn','string'],
          ['max_price','double'],
          ['min_price','double']
        ];
    }

    public function attributeLabels()
    {
        return[
          'name'=>'商品名称',
          'sn'=>'货号',
          'max_price'=>'最高价格',
          'min_price'=>'最低价格',
        ];
    }

    public function search(ActiveQuery $model)
    {
        $this->load(\Yii::$app->request->get());
        if($this->name){
            $model->andwhere(['like','name',$this->name]);
        }
        if($this->sn){
            $model->andwhere(['like','sn',$this->sn]);
        }
        if($this->max_price){
            $model->andwhere(['<=','shop_price',$this->max_price]);
        }
        if($this->min_price){
            $model->andwhere(['>=','shop_price',$this->min_price]);
        }
    }
}