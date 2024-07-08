<?php

namespace app\models\query;

use app\models\Population;

/**
 * This is the ActiveQuery class for [[\app\models\Tblcitymun]].
 *
 * @see \app\models\Tblcitymun
 */
class TblcitymunQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Tblcitymun[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Tblcitymun|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getCityMun($region_c,$province_c){
        $subquery_population_city = Population::find()
            ->join('join','tblcitymun','population.citymun_c = tblcitymun.citymun_c')
            ->select('tblcitymun.citymun_m')
            ->column();

        return parent::
            andWhere(['region_c'=> $region_c])->
            andWhere(['province_c'=>$province_c])->
            andWhere(['not in','citymun_m',$subquery_population_city])
            ->select(['id'=>'citymun_c','name'=>'citymun_m'])
            ->asArray()
            ->all();
    }

    public function getCityMunWhole($region_c,$province_c){
        return parent::
        andWhere(['region_c'=> $region_c])->
        andWhere(['province_c'=>$province_c])
            ->select(['id'=>'citymun_c','name'=>'citymun_m'])
            ->asArray()
            ->all();
    }

    public function getDistrict($region_c,$province_c,$citymun_c){

        return parent::
            andWhere(['region_c'=> $region_c])
            ->andWhere(['province_c'=>$province_c])
            ->andWhere(['citymun_c'=>$citymun_c])
            ->select(['id'=>'district_c','name'=>'district_c'])
            ->asArray()
            ->all();
    }
}
