<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Acticle;
use backend\models\ActicleDetail;
use yii\data\Pagination;
use yii\web\Request;

class ActicleController extends \yii\web\Controller
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
        //实例化文章对象
        $model = Acticle::find();
        //实例化文章详情
        $details = ActicleDetail::find()->all();

        //总页数
        $total = $model->count();
        //每页显示的条数
        $pageSize = 3;
        //当前页数
        $pages = new Pagination([
           'totalCount' => $total,
            'pageSize'=> $pageSize,
        ]);
        //设置SQL语句
        $acticle = $model->limit($pages->limit)->offset($pages->offset)->all();

        return $this->render('index',['acticles'=>$acticle,'pages'=>$pages,'details'=>$details]);
    }

    public function actionAdd(){
        //实例化表单模型
        $model = new Acticle();
        $details = new ActicleDetail();
        //实例化request对象
        $request = new Request();
        //判断接受数据方式
        if($request->isPost){
            $model->load($request->post());
            $details->load($request->post());
            //添加时间
            $model->inputtime = time();
            if($model->validate()){
               //保存数据
                $model->save();
                $id = \Yii::$app->db->getLastInsertID();
                if($details->validate()){
                    $details->acticle_id = $id;
                    //保存ID
                    $details->save();
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['acticle/index']);
                }
        }
            $details->load($request->post());
        }

        //显示页面
        return $this->render('add',['model'=>$model,'details'=>$details]);
    }

    public function actionEdit($id)
    {
        //实例化表单模型
        $acticle_id = $id;
        $model = Acticle::findOne($id);
        $details = ActicleDetail::findOne($acticle_id);
        //实例化request对象
        $request = new Request();
        //判断接受数据方式
        if($request->isPost){
            $model->load($request->post());
            $details->load($request->post());
            //添加时间
            $model->inputtime = time();
            if($model->validate()){
                $id = \Yii::$app->db->getLastInsertID();
                if($details->validate()){
                   //$details->acticle_id = $id;
                    //保存ID
                //保存数据
                $model->save();
                    $details->save();
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect(['acticle/index']);
                }
            }
            $details->load($request->post());
        }

        //显示页面
        return $this->render('add',['model'=>$model,'details'=>$details]);
    }

    public function actionDelete($id)
    {
        //文章详情ID
        $acticle_id = $id;
        //删除文章
        Acticle::findOne($id)->delete();
        ActicleDetail::findOne($acticle_id)->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        //返回页面
        return $this->redirect(['acticle/index']);
    }

}
