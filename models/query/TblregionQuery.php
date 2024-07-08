<?php

namespace app\models\query;

use yii\db\Query;

/**
 * This is the ActiveQuery class for [[\app\models\Tblregion]].
 *
 * @see \app\models\Tblregion
 */
class TblregionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Tblregion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Tblregion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
