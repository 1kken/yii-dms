<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Tblprovince]].
 *
 * @see \app\models\Tblprovince
 */
class TblprovinceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Tblprovince[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Tblprovince|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function getIdandName(){
        return parent::select(['province_m, id']);
    }
    public function getProvinces($region_c){
        return parent::where(['region_c'=>$region_c])->select(['id'=>'province_c','name'=>'province_m'])->asArray()->all();
    }
}
