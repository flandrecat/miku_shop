<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Request;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class MemberController extends \yii\web\Controller
{
    public $layout = 'login';//指定布局文件

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $request = new Request();

        if($request->isPost){
            $model->load($request->post());
            //判断账号密码
            if($model->login()){
                //如果判断成功跳转到index
                \Yii::$app->session->setFlash('success', '登录成功');
                return $this->redirect(['member/index']);
            }
        }
        return $this->render('login', ['model' => $model]);

    }

    public function actionRegister()
    {
        $model = new Member();

        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $model->validateSmsCode($model->smscode);
            $model->password_hash = \Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = \Yii::$app->security->generateRandomString();
            $model->created_at = time();
            $model->save(false);

            \Yii::$app->session->setFlash('success','注册成功');
            return $this->redirect(['member/index']);
        }

        return $this->render('register',['model'=>$model]);
    }

    /**
     * 发送短信验证码
     * App Key: 23742875
     * App Secret: 6acea6e450d3b14d63b3a294a25af884
     */
    public function actionSms(){

        //生成短信验证码
        //接收手机号码
        $tel = \Yii::$app->request->post('tel');
        //随机生成短信验证码
        $code = rand(1000,9999);
        \Yii::$app->session->set('tel_'.$tel,$code);
        //发送短信验证码到手机
        $model = new Member();
        $model->sendSmsCode($tel,$code);
    }

    public function actionTest()
    {
/*        //可以通过 Yii::$app->user 获得一个 User实例，
        $user = \Yii::$app->user;
        // 当前用户的身份实例。未认证用户则为 Null 。
        $identity = \Yii::$app->user->identity;
        var_dump($identity);
        // 当前用户的ID。 未认证用户则为 Null 。
        $id = \Yii::$app->user->id;
        var_dump($id);
        // 判断当前用户是否是游客（未认证的）
        $isGuest = \Yii::$app->user->isGuest;
        var_dump($isGuest);*/

/*        $config = [
            'app_key'    => '23742875',
            'app_secret' => '6acea6e450d3b14d63b3a294a25af884',
        ];
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;

        $req->setRecNum('18202818350')//要发送给谁 电话号码
        ->setSmsParam([
            'number' => rand(1000,9999),//设置参数，根短信模板上的参数名一致
            'name' => '用户',//设置参数，根短信模板上的参数名一致
        ])
            ->setSmsFreeSignName('曾项羽')//签名，必须要设置 签名必须是已审核的
            ->setSmsTemplateCode('SMS_60730158');//短信模板ID

        $resp = $client->execute($req);
        var_dump($resp);*/
    }

}
