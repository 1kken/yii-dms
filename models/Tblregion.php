<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%tblregion}}".
 *
 * @property string $region_c
 * @property string $region_m
 * @property string $abbreviation
 * @property int|null $region_sort
 *
 * @property Tblprovince[] $tblprovinces
 */
class Tblregion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tblregion}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_c', 'region_m', 'abbreviation'], 'required'],
            [['region_sort'], 'integer'],
            [['region_c'], 'string', 'max' => 2],
            [['region_m', 'abbreviation'], 'string', 'max' => 200],
            [['region_c'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'region_c' => 'Region C',
            'region_m' => 'Region M',
            'abbreviation' => 'Abbreviation',
            'region_sort' => 'Region Sort',
        ];
    }

    /**
     * Gets query for [[Tblprovinces]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\TblprovinceQuery
     */
    public function getTblprovinces()
    {
        return $this->hasMany(Tblprovince::class, ['region_c' => 'region_c']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\TblregionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TblregionQuery(get_called_class());
    }

}
