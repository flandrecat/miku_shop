<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_category".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property integer $lft
 * @property integer $rght
 * @property string $level
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
            [['name'], 'required'],
            [['parent_id', 'lft', 'rght', 'level'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
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
            'parent_id' => '父分类',
            'lft' => '左边界',
            'rght' => '右边界',
            'level' => '级别',
            'intro' => '简介',
        ];
    }
}
