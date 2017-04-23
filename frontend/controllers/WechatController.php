<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/22
 * Time: 14:45
 */

namespace frontend\controllers;


use frontend\models\LoginForm;
use frontend\models\Member;
use frontend\models\Order;
use yii\web\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use yii\helpers\Url;
use EasyWeChat\Message\Text;
use yii\web\Request;

class WechatController extends Controller
{
    //必须要有
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $server = $app->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    switch ($message->Event) {
                        case 'subscribe':
                            # code...
                            break;
                        case 'CLICK'://自定义菜单点击事件
                            $articles = [
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2013/04/20130423090055953093.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2011/11/20111114224745296423.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/12/20141225170742418902.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2013/05/20130501145311588608.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/12/20141225171119990603.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/12/20141225144832960024.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/10/20141027222213817061.jpg','Url'=>''],
                                ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2011/11/20111101161958723510.jpg','Url'=>''],
                            ];
                            $result = [];
                            foreach($articles as $article) {
                                $news = new News([
                                    'title' => $article['title'],
                                    'description' => $article['Description'],
                                    'url' => $article['Url'],
                                    'image' => $article['PicUrl'],
                                ]);
                                $result[] = $news;
                            }
                            //根据key值判断点击了哪个按钮
                            return $result;
                            break;
                        default:
                            # code...
                            break;
                    }
                    return '收到事件消息';
                    break;
                case 'text':
                    if($message->Content == '美女排行榜'){
                        $articles = [
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2013/04/20130423090055953093.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2011/11/20111114224745296423.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/12/20141225170742418902.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2013/05/20130501145311588608.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/12/20141225171119990603.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/12/20141225144832960024.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2014/10/20141027222213817061.jpg','Url'=>''],
                            ['title'=>'','Description'=>'','PicUrl'=>'http://mei.hercity.com/data/upfiles/thumb/2011/11/20111101161958723510.jpg','Url'=>''],
                        ];
                        $result = [];
                        foreach($articles as $article){
                            $news = new News([
                                'title'       => $article['title'],
                                'description' => $article['Description'],
                                'url'         => $article['Url'],
                                'image'       => $article['PicUrl'],
                            ]);
                            $result[] = $news;
                        }
                        return $result;
                        /*$news1 = new News(...);
                        $news2 = new News(...);
                        $news3 = new News(...);
                        $news4 = new News(...);
                        return [$news1, $news2, $news3, $news4];*/
                    }elseif($message->Content == '帮助'){
//                        return new Text(['content' => '帮助信息']);
                        return '帮助信息';
                    }

                    break;
                /*case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;*/
            }
            // ...
        });

        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;

    }
    //查询菜单
    public function actionGetMenus()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $menus = $menu->all();
        var_dump($menus);
    }

    //设置菜单
    public function actionSetMenus()
    {
        $app = new Application(\Yii::$app->params['wechat']);
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "热门商品",
                "key"  => "Goods"
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "我的信息",
                        "url"  => Url::to(['wechat/user'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => Url::to(['wechat/orders'],true),
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账号",
                        "url"  => Url::to(['wechat/bang'],true),
                    ],
                ],
            ],
        ];
        $r = $menu->add($buttons);
        //var_dump($r);
    }
    //个人账户信息
    public function actionUser()
    {
        //检查session中是否有openid
        //如果没有
        if(!\Yii::$app->session->get('openid')){
            //获取用户的openid
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->redirect();
            //将当前路由保存到session，便于授权回调地址跳回当前页面
            \Yii::$app->session->setFlash('back','wechat/user');
            $response->send();
        }
        //获得openid
        $openid = \Yii::$app->session->get('openid');
        //查询用户信息
        $member = Member::findOne(['openid'=>$openid]);
        //判断用户是否绑定,没有绑定跳转绑定
        if($member == null){
            return $this->redirect(['wechat/bang']);
        }

        return $this->render('user',['member'=>$member]);

        //var_dump(\Yii::$app->session->get('openid'));
    }

    //查询个人订单
    public function actionOrders()
    {
        //检查session中是否有openid
        //如果没有
        if(!\Yii::$app->session->get('openid')){
            //获取用户的openid
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->redirect();
            //将当前路由保存到session，便于授权回调地址跳回当前页面
            \Yii::$app->session->setFlash('back','wechat/orders');
            $response->send();
        }
        //获得openid
        $openid = \Yii::$app->session->get('openid');
        //查询用户信息
        $member = Member::findOne(['openid'=>$openid]);
        //判断用户是否绑定,没有绑定跳转绑定
        if($member == null){
            return $this->redirect(['wechat/bang']);
        }
        //查询用户订单信息
        $order = Order::findOne(['member_id'=>$member->id]);

        return $this->render('order');
    }

    //网页授权回调地址
    public function actionCallback()
    {
        $app = new Application(\Yii::$app->params['wechat']);
//        echo 'callback';
        $user = $app->oauth->user();
        //用户的openid
        $user->id;
        //将用户的openid保存到session
        \Yii::$app->session->set('openid',$user->id);

        //跳回请求地址
        if(\Yii::$app->session->hasFlash('back')){
            return $this->redirect([\Yii::$app->session->getFlash('back')]);
        }

    }

    public function actionBang()
    {
        $openid = self::actionGetOpenid();
        //实例化登录模型
        $model = new LoginForm();
        $request = new Request();
        $member = new Member();

        if($request->isPost){
            $model->load($request->post());
            //判断账号密码
            if($model->login()){
                //如果判断成功将openid加入到数据库
                $member->openid = $openid;
                $member->update();
                \Yii::$app->session->setFlash('success', '登录成功');
                return $this->redirect(['wechat/user']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionGetOpenid()
    {
        //检查session中是否有openid
        //如果没有
        if(!\Yii::$app->session->get('openid')){
            //获取用户的openid
            $app = new Application(\Yii::$app->params['wechat']);
            $response = $app->oauth->redirect();
            //将当前路由保存到session，便于授权回调地址跳回当前页面
            \Yii::$app->session->setFlash('back','wechat/bang');
            $response->send();
        }
        //获得openid
        $openid = \Yii::$app->session->get('openid');

        return $openid;
    }

}