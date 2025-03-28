<?php

use app\assets\AppAsset;
use app\models\TblCarrera;
use app\models\TblEstadoAlumno;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblAlumno $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="tbl-alumno-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <!-- Primera columna -->
        <div class="col-md-6">

            <?= $form->field($model, 'nombre_alumno')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'correo')->textInput(['maxlength' => true]) ?>
        </div>
        
        <!-- Segunda columna -->
        <div class="col-md-6">

            <?= $form->field($model, 'fk_carrera')->dropDownList(
                ArrayHelper::map(TblCarrera::find()->all(), 'id_carrera', 'nombre_carrera'),
                [
                    'prompt' => 'Seleccione...',
                    'class' => 'form-control tom-select-carrera' 
                ]
            ) ?>

            <?= $form->field($model, 'fk_estado_alumno')->dropDownList(
                        ArrayHelper::map(TblEstadoAlumno::find()->all(), 'id_estado_alumno', 'estado_alumno'),
                        [
                            'prompt' => 'Seleccione...',
                            'id' => 'estado-alumno'
                        ]
            ) ?>

            <?= $form->field($casoSuspension, 'caso_descripcion', [
                'options' => ['id' => 'caso_descripcion-container', 'style' => 'display: none;']
            ])->textarea([
                'id' => 'caso_descripcion-text',
                'rows' => 3
            ]) ?>




                <?= $form->field($model, 'numero_materias')->input('number', ['min' => 0, 'max' => 50])->label('Cantidad de Materias Aprobadas') ?>
        </div>
    </div>

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
$script = <<< JS
$(document).ready(function(){
    function toggleCasoDescripcion() {
        if($('#estado-alumno').val() == '3'){
            $('#caso_descripcion-container').show();
        } else {
            $('#caso_descripcion-container').hide();
            $('#caso_descripcion-text').val(''); 
        }
    }

    toggleCasoDescripcion();

    $('#estado-alumno').change(function(){
        toggleCasoDescripcion();
    });
});
JS;
$this->registerJs($script);

