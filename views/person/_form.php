<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use kartik\datecontrol\DateControl;

/** @var yii\web\View $this */
/** @var app\models\Person $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(
            [
                    'options'=>['class'=>'container']
            ]
    ); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col">
            <?= $form->field($model, 'birthdate')->widget(DateControl::classname(), [
                'type' => 'date',
                'ajaxConversion' => true,
                'autoWidget' => true,
                'displayFormat' => 'php:F-d-Y',
                'saveFormat' => 'php:Y-m-d',
                'saveTimezone' => 'UTC',
                'displayTimezone' => 'Asia/Kolkata',
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'age')->textInput() ?>
        </div>
        <div class="col">
            <?= $form->field($model,'sex')->dropDownList($model->getSex())?>
        </div>
    </div>

    <div class="row">
       <div class="col">
           <?= $form->field($model, 'region_c')->dropDownList($model->getRegions(),['id'=>'region','prompt'=>"Select Region"]); ?>
       </div>
        <div class="col">
            <?= $form->field($model, 'province_c')->widget(DepDrop::class, [
                'options'=>['id'=>'province'],
                'pluginOptions'=>[
                    'depends'=>['region'],
                    'placeholder'=>'Select Province',
                    'url'=>Url::to(['/person/province'])
                ]]);?>
        </div>
        <div class="col">
            <?= $form->field($model, 'citymun_c')->widget(DepDrop::class, [
                'options'=>['id'=>'citymun'],
                'pluginOptions'=>[
                    'depends'=>['region','province'],
                    'placeholder'=>'Select city/municipality',
                    'url'=>Url::to(['/person/cityw'])
                ]]);?>
        </div>
        <div class="col">
            <?= $form->field($model, 'district_c')->widget(DepDrop::class, [
                'options'=>['id'=>'district'],
                'pluginOptions'=>[
                    'depends'=>['region','province','citymun'],
                    'placeholder'=>'Select district',
                    'url'=>Url::to(['/person/district'])
                ]]);?>
        </div>
    </div>
    <div class="row">
       <div class="col">
           <?= $form->field($model, 'contactinfo')->textInput(['maxlength' => true]) ?>
       </div>
        <div class="col">
            <?= $form->field($model,'status')->dropDownList($model->getStatusList())?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

