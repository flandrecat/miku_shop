<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Acticle;
use backend\models\ActicleCategory;
use yii\data\Pagination;
use yii\web\Request;

class ActicleCategoryController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'accessAction'=>[
                'class'=>AccessFilter::className(),
                'only'=>['index','add','edit','delete']
            ]
        ];
    }
    public function actionIndex()
    {
        //实例化对象
        $model = ActicleCategory::find();
        //总条数
        $total = $model->count();
        //每页显示多少条
        $pageSize = 3;
        //当前在第几页
        $pages = new Pagination([
           'totalCount' => $total,
            'pageSize' => $pageSize,
        ]);
        //设置读取数据sql
        $acticle = $model->limit($pages->limit)->offset($pages->offset)->all();

        return $this->render('index',['acticles'=>$acticle,'pages'=>$pages]);
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
        $acticle_category_id = $id;
        $model = Acticle::findAll(['acticle_category_id'=>$acticle_category_id]);
        if($model){
            \Yii::$app->session->setFlash('danger','分类下面还有文章!请先删除文章!');
        }else{
            ActicleCategory::findOne($id)->delete();
        }
        return $this->redirect(['acticle-category/index']);
    }

}
