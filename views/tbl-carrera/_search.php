<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblCarreraSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-carrera-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_carrera') ?>

    <?= $form->field($model, 'nombre_carrera') ?>

    <?= $form->field($model, 'fk_facultad') ?>

    <?= $form->field($model, 'total_materias') ?>

    <?= $form->field($model, 'cant_horas') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
