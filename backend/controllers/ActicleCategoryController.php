<?php

namespace backend\controllers;

use backend\models\ActicleCategory;
use yii\web\Request;

class ActicleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化对象
        $model = ActicleCategory::find()->all();

        return $this->render('index',['model'=>$model]);
    }

    public function actionAdd()
    {
        //实例化模型
        $model = new ActicleCategory();
        //实例化request
        $request = new Request();
        //判断接受方式
        if($request->isPost){
            //接受数据
            $model->load($request->post());
            //验证
            if($model->validate()){
                //保存数据
                $model->save();
                //提示信息
                \Yii::$app->session->setFlash('success','添加成功');
                //返回index
                return $this->redirect(['acticle-category/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id)
    {
        //实例化模型
        $model = ActicleCategory::findOne($id);
        //实例化request
        $request = new Request();
        //判断接受方式
        if($request->isPost){
            //接受数据
            $model->load($request->post());
            //验证
            if($model->validate()){
                //保存数据
                $model->save();
                //提示信息
                \Yii::$app->session->setFlash('success','修改成功');
                //返回index
                return $this->redirect(['acticle-category/index']);
            }
        }
        //显示视图
        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id)
    {
        ActicleCategory::findOne($id)->delete();

        return $this->redirect(['acticle-category/index']);
    }

}
