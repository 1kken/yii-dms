<?php

use app\models\Population;
use app\models\Tblcitymun;
use app\models\Tblprovince;
use app\models\Tblregion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PopulationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Populations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="population-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Population', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'Region',
                'value' => function ($model) {
                    /** @var Population $model */
                    $region = Tblregion::findOne(['region_c'=>$model->region_c])?->region_m;
                    return $region ==null ? 'Not Set':$region;
                },
            ],
            [
                'attribute' => 'Province',
                'value' => function ($model) {
                    /** @var Population $model */
                    $province = Tblprovince::findOne(['region_c'=>$model->region_c,'province_c'=>$model->province_c])?->province_m;
                    return $province==null ? 'Not Set':$province;
                },
            ],
            [
                'attribute' => 'City/Municipality',
                'value' => function ($model) {
                    /** @var Population $model */
                    $citymun = Tblcitymun::findOne(['region_c'=>$model->region_c,'province_c'=>$model->province_c,'citymun_c'=>$model->citymun_c])?->citymun_m;
                    return $citymun==null ? 'Not Set':$citymun;
                },
            ],
            'population',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Population $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
