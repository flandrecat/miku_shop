<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "acticle_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ActicleCategory extends \yii\db\ActiveRecord
{
    public static $status_name = ['1'=>'是','0'=>'否'];
    public static $is_help_name = ['1'=>'是','0'=>'否'];
    /**
     * @inheritdoc
     * 文章分类表
     */
    public static function tableName()
    {
        return 'acticle_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['intro'], 'string'],
            [['status', 'sort', 'is_help'], 'integer'],
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
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否是帮助相关的分类',
        ];
    }
}
