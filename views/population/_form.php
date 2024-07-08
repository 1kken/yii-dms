<?php

use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Population $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="population-form">

    <?php $form = ActiveForm::begin(
        [
            'options'=>['class'=>'container']
        ]
    ); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'region_c')->dropDownList($model->getRegions(),['id'=>'region','prompt'=>'Select Region']); ?>
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
                    'url'=>Url::to(['/person/city'])
                ]]);?>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-4 ">
            <?= $form->field($model, 'population')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

    $script = <<<JS
    //if region and province and citymun is selected and have value
    //populate the population field
    $('#citymun').on('change',function(){
        let region = $('#region').val();
        let province = $('#province').val();
        let citymun = $('#citymun').val();
        if(region && province && citymun){
            $.get('/population/population',{region:region,province:province,citymun:citymun},function(data){
                $('#population-population').val(data);
            });
        }
    }); 

    JS;

    $this->registerJs($script);
    ?>
