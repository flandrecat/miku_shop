<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "acticle".
 *
 * @property integer $id
 * @property string $name
 * @property string $acticle_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property string $inputtime
 */
class Acticle extends \yii\db\ActiveRecord
{
    public static $status_name = ['1'=>'是','0'=>'否'];
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
            [['acticle_category_id', 'status', 'sort', 'inputtime'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique','message'=>'已经存在该文章名字'],
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
            'acticle_category_id' => '文章分类',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '录入时间',
        ];
    }

    public static function getActicleCategoryOptions()
    {
        $category = ActicleCategory::find()->asArray()->all();

        return ArrayHelper::map($category,'id','name');
    }

    public function getActicleCategory()
    {
        return $this->hasOne(ActicleCategory::className(),['id'=>'acticle_category_id']);
    }

}
