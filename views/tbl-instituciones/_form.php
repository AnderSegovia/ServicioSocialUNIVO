<?php

use app\assets\AppAsset;
use app\models\TblDistritos;
use app\models\TblActividad;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblInstituciones $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="tbl-instituciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_institucion')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'fk_actividad')->dropDownList(
                ArrayHelper::map(TblActividad::find()->all(), 'id_actividad', 'nombre_actividad'),
                ['prompt' => 'Seleccione...']
            ) ?>

    <?= $form->field($model, 'nombre_encargado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saludo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono_encargado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correo_encargado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_distritoInst')->dropDownList(
    ArrayHelper::map(TblDistritos::find()->all(), 'id_distrito', 'nombre_distrito'),
    [
        'prompt' => 'Seleccione...',
        'class' => 'form-control tom-select-carrera' // Clase personalizada para Tom Select
    ]
) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
    new TomSelect('.tom-select-carrera', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });
");
?>