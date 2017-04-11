<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/9
 * Time: 16:02
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AddressAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css',
        'style/footer.css',
    ];
    public $js = [
         'js\jquery-1.8.3.min.js',
         'js\header.js',
         'js\home.js',
         //'yii\web\js\home.js',
         'js/jsAddress.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $jsOptions = [
         'position' => View::POS_HEAD
    ];
}








