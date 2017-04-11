<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/11
 * Time: 16:35
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class GoodsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/goods.css',
        'style/common.css',
        'style/bottomnav.css',
        'style/footer.css',
        'style/jqzoom.css',
    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js',
        'js/goods.js',
        'js/jqzoom-core.js',
    ];
}