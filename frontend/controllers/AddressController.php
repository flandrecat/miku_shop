<?php

namespace frontend\controllers;

use frontend\models\Address;

class AddressController extends \yii\web\Controller
{
    public $layout = 'address';//指定布局文件
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        $model = new Address();

        if($model->load(\Yii::$app->request->post())){

            $model->save();
            return $this->refresh();
        }

        return $this->render('address',['model'=>$model]);
    }

    public function actionEdit()
    {

    }

    public function actionDelete($id)
    {
        Address::findOne(['id'=>$id])->delete();

    }

}
