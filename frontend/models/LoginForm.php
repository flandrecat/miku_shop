<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/2
 * Time: 11:18
 */

namespace frontend\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $remember = true;
    //public $code;

    public function rules()
    {
        return [
          [['username','password'],'required'],
          ['remember','safe'],
          //['code','captcha'],

        ];
    }

    public function attributeLabels()
    {
        return[
            'username'=>'用户名',
            'password'=>'密码',
            'remember'=>'记住我',
           // 'code'=>'验证码',
        ];
    }
    //进行登录验证
    public function login(){
        //进行验证
        if($this->validate()){
            //判断是否有该用户
            //$user = Admin::findOne(['or','username'=>$this->username,'email'=>$this->username]);
            $user = Member::findOne(['username'=>$this->username])? Member::findOne(['username'=>$this->username]): Member::findOne(['email'=>$this->username]);
            //如果有该用户则进行密码验证
            if($user){
                //验证密码是否匹配
               if(\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
                   //调用IP查找静态方法
                    $ip = ip2long(self::getClientIP());
                    $user->last_login_ip = $ip;
                    $user->last_login_time = time();
                    $user->save(false);
                    //var_dump($user);exit;
                   //密码验证成功保存session
                   \Yii::$app->user->login($user,3600*24*30);
                   //登录后查看cookie中有没有购物记录
                   //取出购物车数据
                   $member_id = \Yii::$app->user->id;//获取当前用户ID
                   $cookies = \Yii::$app->request->cookies;
                   $cookie = $cookies->get('cart');
                   //判断是否cookie为空
                   if($cookie != null){
                       //cookie有值
                       $cart = unserialize($cookie->value);
                       //查看该用户的购物车记录
                       $model = new Cart();
                       foreach ($cart as $k=>$v){
                            $row = Cart::find()->where(['member_id'=>$member_id])->andWhere(['goods_id'=>$k])->one();
                               if($row){
                                    //如果有商品则在基础上增加数量
                                    $row->amount += $v;
                                    $row->save();
                               }else{
                                    //没有则新增
                                   $model->goods_id = $k;
                                   $model->member_id = $member_id;
                                   $model->amount = $v;
                                   $model->save();
                               }
                       }
                   }
                   return true;
               }else{
                   $this->addError('password','密码错误');
               }
            }else{
                $this->addError('username','用户名错误');
            }
        }
        return false;
    }

    public static function getClientIP()
    {
        global $ip;
        //获取客户端的IP地址
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        //通过代理服务器取得客户端的真实 IP 地址
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else $ip = "Unknow";
        return $ip;
    }

}