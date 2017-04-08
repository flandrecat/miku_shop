<?php

namespace backend\models;

use backend\components\GoodsCategoryQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property string $id
 * @property string $name
 * @property integer $tree
 * @property string $parent_id
 * @property integer $lft
 * @property integer $rgt
 * @property string $depth
 * @property string $intro
 */
class GoodsCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['tree', 'parent_id', 'lft', 'rgt', 'depth'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique','message'=>'已经存在该分类'],
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
            'tree' => '树',
            'parent_id' => '父分类',
            'lft' => '左边界',
            'rgt' => '右边界',
            'depth' => '级别',
            'intro' => '简介',
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new GoodsCategoryQuery(get_called_class());
    }
}
