<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Menu;

class MenuController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','edit','delete'],
            ]
        ];
    }

    public function actionIndex()
    {
        //实例化模型
        $model = Menu::find()->where(['parent_id'=>'0'])->all();

        return $this->render('index',['models'=>$model]);
    }

    public function actionAdd()
    {
        //实例化模型
        $model = new Menu();
        //接受数据,验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->parent_id !== 0){
                $depth = 1;
                $model->depth =$depth;
            }
            //保存
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['menu/index']);
        }
      return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id)
    {
        //实例化模型
        $model = Menu::findOne(['id'=>$id]);
        //接受数据,验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //保存
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['menu/index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id)
    {
        $parent_id = $id;
        $model = Menu::findAll(['parent_id'=>$parent_id]);
        if($model){
            \Yii::$app->session->setFlash('danger','分类下面还有子类!请先删除子类!');
        }else{
            Menu::findOne(['id'=>$id])->delete();
        }
        return $this->redirect(['menu/index']);
    }
}
