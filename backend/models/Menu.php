<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $url
 * @property string $intro
 * @property string $depth
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id','depth'], 'integer'],
            [['intro'], 'string'],
            [['name', 'url'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'parent_id' => '上级ID',
            'url' => '路由',
            'intro' => '描述',
            'depth'=>'深度',
        ];
    }

    /**
     * @return int
     */
    public static function getMenuOptions()
    {
        $arr = [''=>'= 请选择 =','0' => '顶级分类'];

        $parentID = Menu::find()->where(['=','parent_id','0'])->asArray()->all();

       $Menu = ArrayHelper::map($parentID,'id','name');

       return ArrayHelper::merge($arr,$Menu);
    }

    public function getMenus()
    {
        return $this->hasMany(Menu::className(),['parent_id'=>'id']);
    }
}
