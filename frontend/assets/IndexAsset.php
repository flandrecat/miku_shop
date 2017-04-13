<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/11
 * Time: 10:39
 */

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class IndexAsset extends  AssetBundle
{    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/index.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/list.css',
        'style/common.css',


    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js',
        'js/index.js',
        'js/list.js',
    ];

    public $depends = [
        //'yii\web\JqueryAsset',
        //'yii/web/yiiAsset'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}