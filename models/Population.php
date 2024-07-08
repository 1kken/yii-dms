<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%population}}".
 *
 * @property int $id
 * @property string|null $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property int $population
 */
class Population extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%population}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_c', 'citymun_c', 'population'], 'required'],
            [['population'], 'integer'],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_c' => 'Citymun C',
            'population' => 'Population',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PopulationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PopulationQuery(get_called_class());
    }

    public function getRegions(){
        $regions = TblRegion::find()->all();
        return ArrayHelper::map($regions, 'region_c', 'region_m');
    }


    public function getPopulation($region,$province,$citymun){
    }

}
