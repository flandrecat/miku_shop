<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/8
 * Time: 9:06
 */
namespace backend\filters;

use yii\base\ActionFilter;
use yii\web\HttpException;

class AccessFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        if(!\Yii::$app->user->can($action->uniqueId)){

            if(\Yii::$app->user->isGuest){

                return $action->controller->redirect(\Yii::$app->user->loginUrl);

            }
            throw new HttpException(403,'对不起,您没有改操作权限!');
            return false;
        }
        return parent::beforeAction($action);
    }
}