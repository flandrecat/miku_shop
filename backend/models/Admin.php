<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $create_at
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $roles;
    public $repassword;

    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['status', 'create_at', 'last_login_time'], 'integer'],
            [['username', 'password', 'email', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['last_login_ip'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['repassword'],'compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
            ['roles','safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
            'auth_key' => '钥匙',
            'password_reset_token' => '令牌',
            'status' => '状态',
            'create_at' => '注册时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登录IP',
            'repassword'=>'确认密码',
            'roles'=>'角色',
        ];
    }

    public static function getRolesOptions()
    {
        $authManager = Yii::$app->authManager;
        //获得所有权限
        $roles = $authManager->getRoles();
        return ArrayHelper::map($roles,'name','description');
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    public function getMenuItems()
    {
        $menuItems = [];
        //找到所有的顶级分类
        $menus = Menu::find()->where(['parent_id' => '0'])->all();
        foreach ($menus as $menu) {
            $items = [];
            $rows = Menu::find()->where(['parent_id' => $menu->id])->all();
            foreach ($rows as $row) {
                if(Yii::$app->user->can($row->url)){
                   $items []= ['label' => $row->name, 'url' => [$row->url]];
                }
            }
                    $menuItems[] = [
                        'label' => $menu->name,
                        'items' => $items,
                    ];
/*                   $re =  [  'label' => '品牌管理',
                        'items' => [
                            ['label' => '品牌列表', 'url' => ['brand/index']],
                            ['label' => '添加品牌', 'url' => ['brand/add']],
                                    ]
                          ];*/
        }
        return $menuItems;
        //var_dump($re);
       // var_dump($menuItems);exit;
    }
}
