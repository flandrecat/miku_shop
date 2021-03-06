<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/2
 * Time: 11:18
 */

namespace backend\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $remember;

    public function rules()
    {
        return [
          [['username','password'],'required'],
          ['remember','safe'],

        ];
    }

    public function attributeLabels()
    {
        return[
            'username'=>'用户名',
            'password'=>'密码',
            'remember'=>'记住我',
        ];
    }
    //进行登录验证
    public function login(){
        //进行验证
        if($this->validate()){
            //判断是否有该用户
            //$user = Admin::findOne(['or','username'=>$this->username,'email'=>$this->username]);
            $user = Admin::findOne(['username'=>$this->username])? Admin::findOne(['username'=>$this->username]): Admin::findOne(['email'=>$this->username]);
            //如果有该用户则进行密码验证
            if($user){
                //验证密码是否匹配
               if(\Yii::$app->security->validatePassword($this->password,$user->password)){
                   //调用IP查找静态方法
                    $ip = self::getClientIP();
                    $user->last_login_ip = $ip;
                    $user->last_login_time = time();
                    $user->save();
                   //密码验证成功保存session
                   \Yii::$app->user->login($user,3600*24*30);
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