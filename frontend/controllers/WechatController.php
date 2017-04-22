<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/22
 * Time: 14:45
 */

namespace frontend\controllers;


use yii\web\Controller;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    public function actionIndex()
    {
        // 使用配置来初始化一个项目。
        $app = new Application(\Yii::$app->params['wechat']);
        $response = $app->server->serve();
        // 将响应输出
        $response->send();
    }
}