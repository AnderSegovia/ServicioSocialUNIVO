<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoAlumno $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-estado-alumno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'estado_alumno')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
