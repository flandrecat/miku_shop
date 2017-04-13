<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/13
 * Time: 15:16
 */

namespace frontend\controllers;


use backend\models\Goods;
use yii\web\Controller;
use yii\web\Cookie;

class CartController extends Controller
{

    //指定布局文件
    public $layout = 'cart';

    public function actionNotice($pc,$goods_id)
    {
        //判断是否登录
        if(\Yii::$app->user->isGuest){
            //如果是游客取出购物车数据
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            //判断是否cookie为空
            if($cookie == null){
                $cart = [];
            }else {
                //cookie有值
                $cart = unserialize($cookie->value);
            }
            //将coolie中的商品ID与数量保存到cookie
            //判断是否有相同的商品,有则增加数量,否则增加商品  key_exists() = array_key_exists()
            if(array_key_exists($goods_id,$cart)){
                $cart[$goods_id] += $pc;
            }else{
                $cart[$goods_id] = $pc;
            }
        }
        //判断cookie中有没有商品数据,相同的数据合并
        //未登录时将购物车数据保存到cookie
        $cookies = \Yii::$app->response->cookies;
        $cookie = new Cookie([
            'name'=>'cart',
            'value'=>serialize($cart),
        ]);
        $cookies->add($cookie);
        //直接跳转到购物车
        return $this->redirect(['cart/cart']);
    }

    public function actionCart()
    {
        //判断用户是否登录
        if(\Yii::$app->user->isGuest){
             //将商品从cookie中取出
            $cookies = \Yii::$app->request->cookies;
            $cookie = $cookies->get('cart');
            //判断cookie是非有值
            if($cookie == null){
                $cart = [];
            }else{
                $cart = unserialize($cookie->value);
            }
        }else{
            //用户已经登录,将商品从数据表中读取
            //$cart = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->asArray()->all();
        }
        return $this->render('cart',['carts'=>$cart]);
    }
}