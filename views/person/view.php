<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Person $model */

$this->title = $model->first_name. " ". $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'last_name',
            'birthdate',
            'age',
            [
                'label'=>'Sex',
                'value'=>$model->getSex()[$model->sex],
            ],
            [
                'label'=>'Region',
                'value'=>$model->getValueRegion($model->region_c)['region_m'],
            ],
            [
                'label'=>'Province',
                'value'=>$model->getValueProvince($model->province_c)['province_m'],
            ],
            [
                'label'=>'City/Municipality',
                'value'=>$model->getValueCityMun($model->citymun_c)['citymun_m'],
            ],
            'district_c',
            'contactinfo',
            [
                'label'=>'Status',
                'value'=>$model->getStatusList()[$model->status],
            ],
            'date_created',
            'date_updated',
        ],
    ]) ?>

</div>
