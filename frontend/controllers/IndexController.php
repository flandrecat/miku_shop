<?php

namespace frontend\controllers;

use frontend\models\GoodsCategory;

class IndexController extends \yii\web\Controller
{
    //指定布局文件
    public $layout = 'index';

    public function actionIndex()
    {
        $models = GoodsCategory::find()->where(['parent_id'=>'0'])->all();

        return $this->render('index',['models'=>$models]);
    }

}
