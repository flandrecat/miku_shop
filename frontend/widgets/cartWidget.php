<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/13
 * Time: 16:46
 */

namespace frontend\widgets;


use backend\models\Goods;
use yii\base\Widget;
use yii\helpers\Html;

class cartWidget extends Widget
{
    public $goods ;
    public function run()
    {

        $html='';
        foreach($this->goods as $k=>$v){
            //找到商品数据
            $goods = Goods::findOne(['id'=>$k]);
            //图片地址
            $img = Html::img(\Yii::$app->params['picUrl'].$goods->logo);
            $html .='<tr>
            <td class="col1"><a href="">'.$img.'</a>  <strong><a href=""></a></strong></td><td class="col3">￥<span>'.$goods->shop_price.'</span></td>
                         <td class="col4">
                            <a href="javascript:;" class="reduce_num"></a>
                            <input type="text" name="amount" value='.$v.' class="amount"/>
                            <a href="javascript:;" class="add_num"></a>
                        </td>
                        <td class="col5">￥<span>'.$v*$goods->shop_price.'</span></td>
                        <td class="col6"><a href="">删除</a></td>
                        </tr>';
        }
        return $html;
    }
}