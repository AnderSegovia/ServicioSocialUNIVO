<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblProyectoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-proyecto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_proyecto') ?>

    <?= $form->field($model, 'nombre_proyecto') ?>

    <?= $form->field($model, 'numero_registro') ?>

    <?= $form->field($model, 'horario') ?>

    <?= $form->field($model, 'fecha_inicio') ?>

    <?php // echo $form->field($model, 'fecha_fin') ?>

    <?php // echo $form->field($model, 'cant_beneficiados') ?>

    <?php // echo $form->field($model, 'cant_inversion') ?>

    <?php // echo $form->field($model, 'fk_estado_proyecto') ?>

    <?php // echo $form->field($model, 'fk_institucion') ?>

    <?php // echo $form->field($model, 'fk_impacto') ?>

    <?php // echo $form->field($model, 'fk_carrera_proyecto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
