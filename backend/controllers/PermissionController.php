<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\PermissionForm;
use yii\web\Request;

class PermissionController extends \yii\web\Controller
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
        $authManager = \Yii::$app->authManager;

        $permissions = $authManager->getPermissions();

        return $this->render('index',['permissions'=>$permissions]);
    }

    public function actionAdd()
    {
        //实例化表单模型
        $model = new PermissionForm();
        //接受数据,并验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //实例化authManager组件
            $authManager = \Yii::$app->authManager;
            //创建权限
            $permission = $authManager->createPermission($model->name);
            $permission->description  = $model->description;
            //保存
            $authManager->add($permission);

            \Yii::$app->session->setFlash('success','权限添加成功');
            return $this->redirect(['permission/index']);
        }
        //渲染
        return $this->render('add',['model'=>$model]);
    }


    public function actionDelete($name)
    {
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //找到权限
        $permission = $authManager->getPermission($name);
        //删除
        $authManager->remove($permission);
        \Yii::$app->session->setFlash('success','权限删除成功');
        return $this->redirect(['permission/index']);

    }

}
