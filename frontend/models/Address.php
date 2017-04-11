<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $cmbProvince
 * @property string $cmbCity
 * @property string $cmbArea
 * @property string $address
 * @property string $tel
 * @property integer $status
 * @property string $member_id
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'tel'], 'required'],
            [['status'], 'integer'],
            [['name', 'cmbProvince', 'cmbCity', 'cmbArea', 'address', 'member_id'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
            [['cmbProvince', 'cmbCity', 'cmbArea',],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收货人',
            'cmbProvince' => 'Cmb Province',
            'cmbCity' => 'Cmb City',
            'cmbArea' => 'Cmb Area',
            'address' => '详细地址',
            'tel' => '手机号码',
            'status' => '状态',
            'member_id' => '用户id',
        ];
    }
}
