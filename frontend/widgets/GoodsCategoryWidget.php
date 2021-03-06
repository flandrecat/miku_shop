<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/11
 * Time: 21:22
 */
namespace frontend\widgets;

use backend\models\GoodsCategory;
use yii\helpers\Html;

class GoodsCategoryWidget extends \yii\base\Widget
{

    //是否展开分类
    public $expand = false;
    public function run()
    {
        //开启缓存
        $cache = \Yii::$app->cache;
        $id = 'goods_category'.$this->expand;
        $html = $cache->get($id);
        if($html){
            return $html;
        }

        $cat1 = $this->expand?'':'cat1';
        $none = $this->expand?'':'none';

        $html = '';
        //获取一级分类
        $models = GoodsCategory::find()->where(['parent_id' => 0])->all();
        //遍历一级分类
        foreach ($models as $k=>$model) {
            $html .= '<div class="cat '.($k==0 ? 'item1': '').'">
                        <h3>'.Html::a($model->name,['index/list','id'=>$model->id]).'<b></b></h3>
                      <div class="cat_detail">';
            //遍历二级分类
            foreach ($model->goodCategory as $sons){
                $html .= '<dl class="dl_1st">
                                <dt>'.Html::a($sons->name,['index/list','id'=>$sons->id]).'</a></dt>                            
                                    <dd>';

            //遍历三级分类
            foreach ($sons->goodCategory as $son)
                $html .= Html::a($son->name,['index/list','id'=>$son->id]);

                $html .=' </dd>
                        </dl>';
            }
            $html .='</div>
                </div>';
        }

        $html = <<<EOT
        <div class="category fl {$cat1}"> <!-- 非首页，需要添加cat1类 -->
            <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
                <h2>全部商品分类</h2>
                <em></em>
            </div>
            <div class="cat_bd {$none}">
                {$html}
            </div>
        </div>
EOT;
        //保存到缓存
        $cache->set($id,$html,3600*24*7);
        return $html;
    }
}




