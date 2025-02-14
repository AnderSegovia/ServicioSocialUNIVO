<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblInstitucionesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-instituciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_institucion') ?>

    <?= $form->field($model, 'nombre_institucion') ?>

    <?= $form->field($model, 'fk_actividad') ?>

    <?= $form->field($model, 'nombre_encargado') ?>

    <?= $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'cargo') ?>

    <?php // echo $form->field($model, 'saludo') ?>

    <?php // echo $form->field($model, 'telefono_encargado') ?>

    <?php // echo $form->field($model, 'correo_encargado') ?>

    <?php // echo $form->field($model, 'fk_distritoInst') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
