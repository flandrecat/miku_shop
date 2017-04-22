<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/13
 * Time: 15:16
 */

namespace frontend\controllers;


use backend\models\Goods;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use frontend\widgets\cartWidget;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\HttpException;

class CartController extends Controller
{
    public $enableCsrfValidation = false;
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
            //判断cookie中有没有商品数据,相同的数据合并
            //未登录时将购物车数据保存到cookie
            $cookies = \Yii::$app->response->cookies;
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>serialize($cart),
            ]);
            $cookies->add($cookie);
        }else{
            //1 检查购物车有没有该商品(根据goods_id member_id查询)
            $member_id = \Yii::$app->user->id;//获取当前用户ID
            $model = new Cart();

            $row = Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$goods_id])->one();
                if($row){
                    //如果有商品则在基础上增加数量
                    $row->amount += $pc;
                    $row->save();
                }else{
                    //没有则新增
                    $model->goods_id = $goods_id;
                    $model->member_id = $member_id;
                    $model->amount = $pc;
                    $model->save();
                }
        }
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
            $cart = Cart::find()->where(['member_id'=>\Yii::$app->user->id])->asArray()->all();
            $cart = ArrayHelper::map($cart,'goods_id','amount');

        }
        $token =  \Yii::$app->request->csrfToken;
        return $this->render('cart',['carts'=>$cart,'token'=>$token]);
    }

    /**
     * @param $filter
     * 通过字段判断修改还是删除
     * $filter = modify   del
     */
    public function actionAjax($filter)
    {
        switch ($filter){
            case 'modify':
                //修改商品数量 goods_id  num
                $goods_id = \Yii::$app->request->post('goods_id');
                $num = \Yii::$app->request->post('num');

                if(\Yii::$app->user->isGuest){
                    $cookies = \Yii::$app->request->cookies;
                    $cookie = $cookies->get('cart');
                    if($cookie == null){//购物车cookie不存在
                        $cart = [];
                    }else{//购物车cookie存在
                        $cart = unserialize($cookie->value);
                    }
                    $cart[$goods_id] = $num;
                    //将购车数据保存回cookie
                    $cookies = \Yii::$app->response->cookies;
                    $cookie = new Cookie([
                        'name'=>'cart',
                        'value'=>serialize($cart)
                    ]);

                    $cookies->add($cookie);
                }
                return 'success';
                break;
        }
    }

    /**
     * @return string
     * 订单
     */
    public function actionOrder()
    {
        //登录后的用户才能提交订单
        if(\Yii::$app->user->isGuest){
            return $this->redirect('/member/login');
        }else{
            //通过用户ID查找用户信息
            $member_id = \Yii::$app->user->id;
            //收货人信息
            $member_msg = Address::findAll(['member_id'=>$member_id]);
            $delivery = Order::$delivery;
/*            foreach ($delivery as $k=>$v){
                 var_dump($v["delivery_name"]);exit;
            }*/
            $pay = Order::$pay;
            $carts = Cart::find()->where(['member_id'=>$member_id])->all();
            $goods = [];
            foreach ($carts as $cart){
                $row = Goods::find()->where(['id'=>$cart->goods_id])->asArray()->one();
                $row['amount'] = $cart->amount;
                $goods[]= $row;
            }
        }
        return $this->render('order',['member_msgs'=>$member_msg,'deliverys'=>$delivery,'pays'=>$pay,'goods'=>$goods]);
    }

    /*
     * 订单确认
     */
    public function actionSuccess()
    {
        $order = new Order();
        $address_id = \Yii::$app->request->post('address_id');
        //获取用户ID
        $order->member_id = \Yii::$app->user->id;
        //获取收货人信息
        $address = Address::findOne(['id'=>$address_id,'member_id'=>$order->member_id]);
        if($address==null){
            throw new HttpException('404','地址不存在');
        }
        $order->name = $address->name;
        $order->province_name = $address->cmbProvince;
        $order->city_name = $address->cmbCity;
        $order->area_name = $address->cmbArea;
        $order->detail_address = $address->address;
        $order->tel = $address->tel;
        //快递信息
        $order->delivery_id = \Yii::$app->request->post('delivery_id');
        $order->delivery_name = Order::$delivery[$order->delivery_id]["delivery_name"];
        $order->delivery_price = Order::$delivery[$order->delivery_id]["delivery_price"];
        //支付信息
        $order->pay_type_id = \Yii::$app->request->post('pay_id');
        $order->pay_type_name = Order::$pay[$order->pay_type_id]["pay_type_name"];
        //计算总价
        $carts = Cart::findAll(['member_id'=>$order->member_id]);
        $price = '';
        foreach ($carts as $cart)
        {
            //找到商品价格
            $goods = Goods::find()->where(['id'=>$cart->goods_id])->one();
            $price += $goods->shop_price*$cart->amount;
        }
        $order->price = $price;
        //如果支付方式是货到付款，则状态是 待发货；如果是在线支付，则状态是 待付款
        //订单状态 0取消 1等待付款 2待发货 3待收货 4完成
        switch ($order->pay_type_id){
            case '1':
                $order->status = 2;
                break;
            case  '2':
                $order->status = 1;
                break;
            case '3':
                $order->status = 2;
                break;
            case '4';
                $order->status = 1;
                break;
        }
        $order->create_time = time();

        //开启事务回滚
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try{
            $order->save();
            //订单详情表数据
            //从购物车数据表获取商品数据 $carts = [['goods_id'=>1,'amount'=>2],[]]
            //遍历购物车数据
            foreach ($carts as $cart){
                $order_detail = new OrderDetail();
                //订单ID
                $order_detail->order_info_id =$order->id;
                //商品数据
                $order_detail->goods_id = $cart->goods_id;
                $goods = Goods::findOne(['id'=>$order_detail->goods_id]);
                $order_detail->goods_name = $goods->name;
                $order_detail->logo = $goods->logo;
                $order_detail->price = $goods->shop_price;
                //!TODO 检查库存
                $order_detail->amount =$cart->amount;
                if($order_detail->amount > $goods->stock){
                    //库存不足,抛出异常
                    throw new Exception('商品'.$goods->name.'的库存不足');
                }
                //减少商品库存
                $goods->status -= $order_detail->amount;
                $goods->update();
                //计算价格
                $order_detail->total_price = $order_detail->amount*$order_detail->price;
                $order_detail->save();
            }
            //提交事务
            $transaction->commit();
        }catch (Exception $e){
            //失败则回滚
            \Yii::$app->session->setFlash('danger',$e->getMessage());
            $transaction->rollBack();
            return $this->redirect(['cart/cart']);
        }

        return $this->render('success');
    }
}