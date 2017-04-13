<?php

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use yii\web\Cookie;

class IndexController extends \yii\web\Controller
{
    //指定布局文件
    public $layout = 'index';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList($id)
    {
        //实例化模型找到该分类下的商品
        $model = Goods::find()->where(['goods_category_id'=>$id])->all();
        //找到当前父分类名
        $name  = GoodsCategory::findOne(['id'=>$id]);
        if($name->parent_id !=0){
            $name= GoodsCategory::findOne(['id'=>$name->parent_id]);
            if($name->parent_id !=0){
                   $name = GoodsCategory::findOne(['id'=>$name->parent_id]);
                 if($name->parent_id !=0){
                     $name = GoodsCategory::findOne(['id'=>$name->parent_id]);
                 }
            }
        }
        return $this->render('list',['name'=>$name,'models'=>$model]);
    }

    /**
     * @param $id
     * @return string
     * 商品详细页
     */
    public function actionGoods($id)
    {
        $model = Goods::findOne(['id'=>$id]);


        return $this->render('goods',['model'=>$model]);
    }

}
