<?php

namespace backend\controllers;

use backend\models\Brand;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化对象
        $model = Brand::find()->where(['>=','status','0']);
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
        $brand = $model->limit($pages->limit)->offset($pages->offset)->all();

        return $this->render('index', ['brands' => $brand, 'pages' => $pages]);
    }


    public function actionAdd()
    {
        //实例化模型
        $model = new Brand();
        //实例化request
        $request = new Request();
        //判断接受方式
        if($request->isPost){
            $model->load($request->post());
            //实例化上传图片对象
           // $model->logo_img = UploadedFile::getInstance($model,'logo_img');
            //var_dump($model);exit;
            //验证
            if($model->validate()){
                //判断是非有logo_img属性
                /*if($model->logo_img){
                    //生成随机图片名
                    $file_name = 'upload/'.uniqid().'.'.$model->logo_img->extension;
                    //移动上传图片
                    $model->logo_img->saveAs($file_name,false);
                    $model->logo= $file_name;*/
                    //保存
                    $model->save();
                     \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect('index');
                }
            }


        //显示视图
        return $this->render('add',['model'=>$model]);
    }
    
    public function actionEdit($id)
    {
        //实例化模型
        $model = Brand::findOne($id);
        //实例化request
        $request = new Request();
        //判断接受方式
        if($request->isPost){
            $model->load($request->post());
            //实例化上传图片对象
           // $model->logo_img = UploadedFile::getInstance($model,'logo_img');
            //var_dump($model);exit;
            //验证
            if($model->validate()){
                //判断是非有logo_img属性
               /* if($model->logo_img){
                    //生成随机图片名
                    $file_name = 'upload/'.uniqid().'.'.$model->logo_img->extension;
                    //移动上传图片
                    $model->logo_img->saveAs($file_name,false);
                    $model->logo= $file_name;*/
                    //保存
                $model->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect('index');
                }
            }

        //显示视图
        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id)
    {
        //实例化对象
        $model = Brand::findOne($id);
        //修改为删除
        $model->status = -1;
        //保存
        $model->save();
        //返回index
        return $this->redirect(['brand/index']);
    }

    //彻底删除
    public function actionDeletes($id){
        Brand::findOne($id)->delete();
        \Yii::$app->session->setFlash('success','已成功从数据库删除');
        return $this->redirect(['brand/del']);
    }

    //回收站
    public function actionDel()
    {
        //实例化对象
        $model = Brand::find()->where(['=','status','-1']);
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
        $brand = $model->limit($pages->limit)->offset($pages->offset)->all();

        return $this->render('del', ['brands' => $brand, 'pages' => $pages]);
    }

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/brand',
                'baseUrl' => '@web/upload/brand',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //$action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"

                    $ak = 'TEX6NtwC5qtQRc_WWbItDSNL0lAaLhxo31gjYnkx';
                    $sk = 'I-IAl0T4Nz3DKbGpERI5lq8FKcmCzLwHwwbCbiYc';
                    $domain = 'http://onkdikd9h.bkt.clouddn.com/';
                    $bucket = 'mikushop';
                    $qiniu = new Qiniu($ak, $sk,$domain, $bucket);

                    //将本地图片上传到七牛云
                    $qiniu->uploadFile($action->getSavePath(),$action->getFilename());
                    //获取图片在七牛云上的地址
                    $url = $qiniu->getLink($action->getFilename());
                    //将七牛云的地址返回给前端JS
                    $action->output['fileUrl'] = $url;

                },
            ],
        ];
    }

}
