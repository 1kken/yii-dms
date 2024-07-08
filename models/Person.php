<?php

namespace app\models;

use app\models\query\PersonQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%person}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthdate
 * @property int $age
 * @property int $sex
 * @property string $region_c
 * @property string $province_c
 * @property string $citymun_c
 * @property string $district_c
 * @property string $contactinfo
 * @property int $status
 * @property string $date_created
 * @property string $date_updated
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%person}}';
    }

    /**
     * {@inheritdoc }
     */
    public function behaviors()
    {
        return[
            [
                'class'=>TimestampBehavior::class,
                'createdAtAttribute'=>'date_created',
                'updatedAtAttribute'=>'date_updated',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['first_name', 'last_name', 'birthdate', 'age', 'sex', 'region_c', 'province_c', 'citymun_c', 'district_c', 'contactinfo', 'status'], 'required'],
            [['birthdate', 'date_created', 'date_updated'], 'safe'],
            [['age', 'sex', 'status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['region_c', 'province_c', 'citymun_c'], 'string', 'max' => 2],
            [['district_c'], 'string', 'max' => 3],
            [['contactinfo'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthdate' => 'Birthdate',
            'age' => 'Age',
            'sex' => 'Sex',
            'region_c' => 'Region C',
            'province_c' => 'Province C',
            'citymun_c' => 'Citymun C',
            'district_c' => 'District C',
            'contactinfo' => 'Contactinfo',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PersonQuery(get_called_class());
    }

    public function getRegions(){
            $regions = TblRegion::find()->all();
            return ArrayHelper::map($regions, 'region_c', 'region_m');
    }

    public static function getProvinces($region_c){
        return Tblprovince::find()->getProvinces($region_c);
    }

    public static function getCityMun($region_c,$province_c){
        $citymun = Tblcitymun::find()->getCityMun($region_c,$province_c);
        return ['out'=>$citymun,'selected'=>''];
    }

    public static function getCityMunWhole($region_c,$province_c){
        $citymun = Tblcitymun::find()->getCityMunWhole($region_c,$province_c);
        return ['out'=>$citymun,'selected'=>''];
    }
    public static function getDistrict($region_c,$province_c,$citymun_c){
        $district = Tblcitymun::find()->getDistrict($region_c,$province_c,$citymun_c);
        return ['out'=>$district,'selected'=>''];
    }
    public function getStatusList(){
        return [
            0=>'Under Investigation',
            1=>'Surrendered',
            2=>'Apprehended',
            3=>'Escaped',
            4=>'Deceased'
        ];
    }

    public function getSex(){
        return [
            0=>'Male',
            1=>'Female'
        ];
    }

    public function getValueRegion($region_c){
        return Tblregion::findOne(['region_c'=>$region_c]);
    }

    public function getValueProvince($province_c){
       return Tblprovince::findOne(['province_c'=>$province_c]);
    }

    public function getValueCityMun($citymun_c){
       return Tblcitymun::findOne(['citymun_c'=>$citymun_c]);
    }

    public static function getPopulation($params)
    {
        return self::find()->andWhere($params);
    }

    public static function getStatusCountsByAge($ageRange,$params,$status)
    {
        $query = Person::find()
            ->andWhere(['status'=>$status])
            ->getCountByBracket()
            ->andWhere($params)
            ->andwhere(['between', 'age', $ageRange[0], $ageRange[1]])
            ->asArray();
        return $query->all();
    }
}
