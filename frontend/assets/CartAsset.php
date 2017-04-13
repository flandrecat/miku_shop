<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/13
 * Time: 15:13
 */

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class CartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/cart.css',
        'style/footer.css',
    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/cart1.js',

    ];

    public $depends = [
        //'yii\web\JqueryAsset',
        //'yii/web/yiiAsset'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}