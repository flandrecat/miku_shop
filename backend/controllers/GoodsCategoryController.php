<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\GoodsCategory;
use yii\data\Pagination;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
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
        $Goods = GoodsCategory::find();
        //总条数
        $total = $Goods->count();
        //每页显示多少条
        $pageSize = 10;
        //当前在第几页
        $pages = new Pagination([
            'totalCount' => $total,
            'pageSize' => $pageSize,
        ]);
        //设置读取数据sql
        $models = $Goods->limit($pages->limit)->offset($pages->offset)->orderBy('tree','lft')->all();
        return $this->render('index',['models'=>$models,'pages'=>$pages]);
    }

    public function actionAdd()
    {
        //实例化对象
        $model = new GoodsCategory();
        //实例化request对象
        $request =new Request();
        //判断接受方式
        if($request->isPost){
            $model->load($request->post());
            //验证
            try{
                if($model->validate()){
                    if($model->parent_id ==0){
                        $model->makeRoot();
                    }else{
                        //找到父
                        $parent_russia = GoodsCategory::findOne(['id'=>$model->parent_id]);
                        $model->prependTo($parent_russia);
                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->redirect(['goods-category/index']);
                    }
                }
            }catch(Exception $e){

                $model->addError('parent_id',$e->getMessage());
            }

        }
        //得到所有的分类数据,并转化成JSON格式
        $models = GoodsCategory::find()->asArray()->all();
        //加入顶级分类
        $models[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }

    public function actionEdit($id)
    {
        //实例化对象
        $model = GoodsCategory::findOne($id);
        //实例化request对象
        $request =new Request();
        //判断接受方式
        if($request->isPost){
            $model->load($request->post());
            //验证
            if($model->validate()){
                if($model->parent_id ==0){
                    $model->makeRoot();
                }else{
                    //找到父
                    $parent_russia = GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent_russia);
                }
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods-category/index']);
            }
        }
        //得到所有的分类数据,并转化成JSON格式
        $models = GoodsCategory::find()->asArray()->all();
        //加入顶级分类
        $models[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $models = Json::encode($models);
        return $this->render('add',['model'=>$model,'models'=>$models]);
    }

    public function actionDelete($id)
    {
        $parent_id = $id;
        $model = GoodsCategory::findAll(['parent_id'=>$parent_id]);
        if($model){
            \Yii::$app->session->setFlash('danger','分类下面还有子类!请先删除子类!');
        }else{
            GoodsCategory::findOne(['id'=>$id])->delete();
        }
        return $this->refresh();
    }
}
