<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\RoleForm;

class RoleController extends \yii\web\Controller
{

/*    public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','edit','delete'],
            ]
        ];
    }*/

    public function actionIndex()
    {
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //获取所有角色
        $roles = $authManager->getRoles();
        return $this->render('index',['roles'=>$roles]);
    }

    public function actionAdd()
    {
        //实例化角色模型
        $model = new RoleForm();
        //调用场景
        $model->scenario = RoleForm::SCENARIO_ADD;
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //创建角色
            $role = $authManager->createRole($model->name);
            $role->description = $model->description;
            //保存
            $authManager->add($role);
            //为角色关联权限
            foreach ($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success','角色添加成功');
            return $this->redirect(['role/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($name)
    {
        //实例化角色模型
        $model = new RoleForm();
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //获取角色信息
        $role = $authManager->getRole($name);
        $model->name = $role->name;
        $model->description =$role->description;
        //获取角色拥有的权限
        $model->permissions = array_keys($authManager->getPermissionsByRole($role->name));

        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            $role->description = $model->description;
            //更新
            $authManager->update($role->name,$role);
            //为角色关联权限,在此之前先清空权限
            $authManager->removeChildren($role);
            foreach ($model->permissions as $permission){
                $authManager->addChild($role,$authManager->getPermission($permission));
            }
            \Yii::$app->session->setFlash('success','角色添加成功');
            return $this->redirect(['role/index']);
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($name)
    {
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //找到该角色
        $role = $authManager->getRole($name);
        $authManager->remove($role);
        \Yii::$app->session->setFlash('success','权限删除成功');
        return $this->redirect(['role/index']);
    }

}
