<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\GoodsGallery;
use xj\uploadify\UploadAction;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsGalleryController extends \yii\web\Controller
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
    public function actionIndex($id)
    {
        $model = GoodsGallery::findAll(['goods_id'=>$id]);

        return $this->render('index',['models'=>$model,'id'=>$id]);
    }

    public function actionAdd($id)
    {
        $model = new GoodsGallery();

        $model->goods_id = $id;

        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            //实例化上传图片
            $model->img_file = UploadedFile::getInstances($model,'img_file');
            //验证
            if($model->validate()){
                //循环遍历图片地址
                foreach($model->img_file as $img_file){
                    $fileName = 'upload/gallery/'.uniqid().'.'.$img_file->extension;
                    $img_file->saveAs($fileName,false);
                    //保存图片
                    \Yii::$app->db->createCommand()->insert('goods_gallery',[
                        'goods_id'=>$model->goods_id,
                        'path'=>$fileName,
                    ])->query();
                }
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-gallery/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEdit($id)
    {
        $model = GoodsGallery::findOne($id);

        $request = new Request();

        if($request->isPost){

            $model->load($request->post());
            //实例化上传图片
            $model->img_file = UploadedFile::getInstances($model,'img_file');
            //验证
            if($model->validate()){
                //循环遍历图片地址
                foreach($model->img_file as $img_file){
                    $fileName = 'upload/gallery/'.uniqid().'.'.$img_file->extension;
                    $img_file->saveAs($fileName,false);
                    //保存图片
                    \Yii::$app->db->createCommand()->insert('goods_gallery',[
                        'goods_id'=>$model->goods_id,
                        'path'=>$fileName,
                    ])->query();
                }
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/index']);
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionDelete($id)
    {
        GoodsGallery::findOne(['id'=>$id])->delete();

        return $this->refresh();
    }

    public function actions()
    {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/goods/gallery',
                'baseUrl' => '@web/upload/goods/gallery',
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
                    'maxSize' => 2 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {
                },
                'beforeSave' => function (UploadAction $action) {
                },
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    /*                    $ak = 'TEX6NtwC5qtQRc_WWbItDSNL0lAaLhxo31gjYnkx';
                                        $sk = 'I-IAl0T4Nz3DKbGpERI5lq8FKcmCzLwHwwbCbiYc';
                                        $domain = 'http://onkdikd9h.bkt.clouddn.com/';
                                        $bucket = 'mikushop';
                                        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);

                                        //将本地图片上传到七牛云
                                        $qiniu->uploadFile($action->getSavePath(),$action->getFilename());
                                        //获取图片在七牛云上的地址
                                        $url = $qiniu->getLink($action->getFilename());
                                        //将七牛云的地址返回给前端JS
                                        $action->output['fileUrl'] = $url;*/
                },
            ],
        ];

    }
}
