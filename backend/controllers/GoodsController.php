<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use backend\models\GoodsSearch;
use xj\uploadify\UploadAction;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\rest\ViewAction;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
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

        //实例化对象
        $model = Goods::find()->where(['status'=>'1']);
        //实例化表单模型
        $search = new GoodsSearch();
        $search->search($model);
        //当前在多少页
        $pages = new Pagination([
            'totalCount' => $model->count(),
            'pageSize' => 3,
        ]);
        //设置读取数据sql
        $goods = $model->limit($pages->limit)->offset($pages->offset)->all();

        return $this->render('index', ['goods' => $goods,'search'=>$search,'pages' => $pages]);
    }

    public function actionAdd()
    {
        //实例化模型
        $model = new Goods();
        $goodsIntro = new GoodsIntro();
        $goodsCount = new GoodsDayCount();
        $request = new Request();
        if($request->isPost){
            //接受数据
            $model->load($request->post());
            $goodsIntro->load($request->post());

            //判断goodsDayCount表是否有今天的数据
            $goodsCount->day = date('Y-m-d');
            $rs = $goodsCount::findOne($goodsCount->day);
                //如果有则商品数量+1,否则创建
                if($rs){
                    $rs->count++;
                    $rs->save();
                }else{
                    $goodsCount->day = date('Y-m-d');
                    $goodsCount->count = 1;
                    $goodsCount->save();
                }
                //验证
            if($model->validate() && $goodsIntro->validate()){
                    //自动生成货号
                    $count = $goodsCount::findOne($goodsCount->day)->count;
                    $model->inputtime = time();
                    $model->sn = $sn =date('Ymd').str_pad($count,4,0,STR_PAD_LEFT);
                    $model->save();

                    $goodsIntro->goods_id = $model->id;
                    $goodsIntro->save();
                    //返回index
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['goods-gallery/add'.'?id='.$model->id]);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        //加入顶级分类
        $models[] = ['id' => 0, 'parent_id' => 0, 'name' => '顶级分类'];
        $models = Json::encode($models);
        return $this->render('add', ['model' => $model, 'models' => $models, 'goodsintro' => $goodsIntro]);
    }

    public function actionGallery()
    {
        $model = new GoodsGallery();

        return $this->render('gallery', ['model' => $model]);
    }


    public function actionEdit($id)
    {
        //实例化模型
        $model = Goods::findOne($id);
        $goodsIntro = GoodsIntro::findOne($model->id);

        $request = new Request();
        if($request->isPost){
            //接受数据
            $model->load($request->post());
            $goodsIntro->load($request->post());

            //验证
            if($model->validate() && $goodsIntro->validate()){

                $model->save();
                $goodsIntro->save();
                //返回index
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods/index']);
            }
        }
        $models = GoodsCategory::find()->asArray()->all();
        //加入顶级分类
        $models[] = ['id' => 0, 'parent_id' => 0, 'name' => '顶级分类'];
        $models = Json::encode($models);
        return $this->render('add', ['model' => $model, 'models' => $models, 'goodsintro' => $goodsIntro]);
    }

    public function actionDelete($id)
    {
        Goods::findOne(['id'=>$id])->delete();
        GoodsIntro::findOne(['goods_id'=>$id])->delete();

        \Yii::$app->session->set('success','删除成功');
        return $this->redirect(['goods/index']);
    }

     public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload/goods',
                'baseUrl' => '@web/upload/goods',
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
