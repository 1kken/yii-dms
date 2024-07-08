<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tblprovince}}".
 *
 * @property string $region_c
 * @property string $province_c
 * @property string $province_m
 * @property string $income
 *
 * @property Tblregion $regionC
 */
class Tblprovince extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tblprovince}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'province_c', 'province_m', 'income'], 'required'],
            [['region_c', 'province_c'], 'string', 'max' => 2],
            [['province_m'], 'string', 'max' => 200],
            [['income'], 'string', 'max' => 20],
            [['province_c'], 'unique'],
            [['region_c'], 'exist', 'skipOnError' => true, 'targetClass' => Tblregion::class, 'targetAttribute' => ['region_c' => 'region_c']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'province_m' => 'Province M',
            'income' => 'Income',
        ];
    }

    /**
     * Gets query for [[RegionC]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TblregionQuery
     */
    public function getRegionC()
    {
        return $this->hasOne(Tblregion::class, ['region_c' => 'region_c']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\TblprovinceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TblprovinceQuery(get_called_class());
    }

}
