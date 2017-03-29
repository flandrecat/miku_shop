<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "acticle_detail".
 *
 * @property integer $acticle_id
 * @property string $content
 */
class ActicleDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * 文章详细表
     */
    public static function tableName()
    {
        return 'acticle_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'acticle_id' => 'ID',
            'content' => '文章类容',
        ];
    }
}
