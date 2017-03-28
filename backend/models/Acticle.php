<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "acticle".
 *
 * @property integer $id
 * @property string $name
 * @property string $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property string $inputtime
 */
class Acticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * 文章表
     */
    public static function tableName()
    {
        return 'acticle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'inputtime'], 'required'],
            [['article_category_id', 'status', 'sort', 'inputtime'], 'integer'],
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
            'article_category_id' => '文章分类',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }
}
