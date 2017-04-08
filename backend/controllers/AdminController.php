<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;
use backend\models\Menu;
use yii\data\Pagination;
use yii\debug\models\search\Log;
use yii\filters\AccessControl;
use yii\web\Request;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化对象
        $model = Admin::find();
        //总共数据条数
        $total = $model->count();
        //每页显示的条数
        $pageSize = 3;
        //当前在多少页
        $pages = new Pagination([
            'totalCount' => $total,
            'pageSize' => $pageSize,
        ]);
        //设置读取数据sql
        $admin = $model->limit($pages->limit)->offset($pages->offset)->all();

        return $this->render('index', ['admins' => $admin, 'pages' => $pages]);
    }

    public function actionLogin()
    {
        //实例化登录模型
        $model = new LoginForm();
        $request = new Request();

        if($request->isPost){
            $model->load($request->post());
            //判断账号密码
            if($model->login()){
                //如果判断成功跳转到index
                \Yii::$app->session->setFlash('success', '登录成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('login', ['model' => $model]);
    }
    public function actionLogout()
    {
        //清除session中的数据
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','退出成功');
        return $this->redirect(['admin/login']);
    }


    public function actionAdd()
    {
        //实例化模型
        $model = new Admin();
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //实例化request
        $request = new Request();
        //判断接受方式
        if($request->isPost){
            //接受数据
            $model->load($request->post());
            //验证
            if($model->validate()){
                //加密
                $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->create_at = time();
                $model->last_login_time = time();
                $model->auth_key = \Yii::$app->security->generateRandomString();
                $model->save(false);
                //给用户添加角色
                foreach ($model->roles as $role){
                $authManager->assign($authManager->getRole($role),$model->id);
                }
                \Yii::$app->session->setFlash('success','注册成功');
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id)
    {
        //实例化表单模型
        $model = Admin::findOne($id);
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //获得用户的角色
        //$authManager->getRole($model->username);
        $role = array_keys($authManager->getRolesByUser($id));
        $model->roles = $role;
        $password = $model->password;
        //实例化request对象
        $request = new Request();
        //判断接受方式
        if ($request->isPost){
            //接受数据
            $model->load($request->post());
            //判断密码是否修改
            if ($model->password != $password) {
                $password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->password = $password;
            }
            if ($model->validate()) {
                $model->save(false);
                //清除用户关联的角色
                $authManager->revokeAll($model->id);
                //设置新的角色
                foreach ($model->roles as $role){
                    $authManager->assign($authManager->getRole($role),$model->id);
                }
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['admin/index']);
            }
            //失败跳转添加页面
            return $this->render('add', ['model' => $model]);
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id)
    {
        Admin::findOne(['id'=>$id])->delete();
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //清除用户下的角色
        $authManager->revokeAll($id);

        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['admin/index']);
    }

    public function actionTest()
    {
        //可以通过 Yii::$app->user 获得一个 User实例，
        $user = \Yii::$app->user;

        // 当前用户的身份实例。未认证用户则为 Null 。
        $identity = \Yii::$app->user->identity;
        var_dump($identity);
        // 当前用户的ID。 未认证用户则为 Null 。
        $id = \Yii::$app->user->id;
        var_dump($id);
        // 判断当前用户是否是游客（未认证的）
        $isGuest = \Yii::$app->user->isGuest;
        var_dump($isGuest);
/*        $menuItems = [];
        //找到所有的顶级分类
        $menus = Menu::find()->where(['parent_id' => '0'])->all();
        foreach ($menus as $menu) {
            $items = [];
            $rows = Menu::find()->where(['parent_id' => $menu->id])->all();
            foreach ($rows as $row) {
                \Yii::$app->user->can($row->url);
                $items = ['label' => $row->name, ['url' => $row->url]];
            }
            $menuItems[] = [
                'label' => $menu->name,
                'items' => $items,
            ];
        }
        return $menuItems;*/
    }

    public function behaviors(){
        return [
            'ACF'=>[
                'class'=>AccessControl::className(),
                'only'=>['index','add','login','logout'],
                'rules'=>[
                    [
                        //是否允许
                        'allow'=>true,
                        //那些操作需要认证
                        'actions'=>['index','add','logout'],
                        //已登录的用户才允许操作
                        'roles'=>['@']
                    ],
                    [
                      'allow'=>true,
                      'actions'=>['login'],
                      //未登录的用户
                      'roles'=>['?'],
                    ],
                ],
            ],
        ];
    }



}
