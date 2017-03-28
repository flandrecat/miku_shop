<?php

namespace backend\controllers;

use backend\models\Acticle;

class ActicleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = Acticle::find()->all();

        return $this->render('index',['model'=>$model]);
    }

    public function actionAdd(){

    }

}
