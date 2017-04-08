<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/5
 * Time: 14:01
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name','description'],'required'],
            //自定义判断
            ['name','validatePermission']
        ];
    }
    /**
     *
     */
    public function attributeLabels()
    {
         return [
           'name'=>'名称(路由)',
           'description'=>'描述',
         ];
    }

    public function validatePermission($attribute,$params)
    {
        //实例化authManager组件
        $authManager = \Yii::$app->authManager;
        //判断有没有该权限
        if($authManager->getPermission($this->$attribute)){
            $this->addError($attribute,'权限已经存在');
        }
    }
}