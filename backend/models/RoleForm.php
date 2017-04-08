<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/5
 * Time: 15:21
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model
{
    public $name;
    public $description;
    //权限
    public $permissions = [];

    //定义场景
    const SCENARIO_ADD = 'add';

    //当字段不一致的时候用下面的方法
    public function scenarios(){
        $scenarios =  parent::scenarios();
        return ArrayHelper::merge($scenarios,[
            self::SCENARIO_ADD => ['name','description','permissions'],
        ]);
    }
    public function rules()
    {
        return [
            [['name','description'],'required'],
            //自定义判断
            ['name','validateName','on'=>self::SCENARIO_ADD],
            ['permissions','safe'],
        ];
    }
    /**
     *
     */
    public function attributeLabels()
    {
        return [
            'name'=>'角色',
            'description'=>'描述',
            'permissions'=>'权限',
        ];
    }

    public function validateName($attribute,$params)
    {
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //判断有没有该权限
        if($authManager->getRole($this->$attribute)){
            $this->addError($attribute,'角色已经存在');
        }
    }

    public static function  getPermissionOptions()
    {
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //获得所有权限
        $permissions = $authManager->getPermissions();
        return ArrayHelper::map($permissions,'name','description');
    }
}