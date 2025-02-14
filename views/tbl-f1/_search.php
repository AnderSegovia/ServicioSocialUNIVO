<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblF1Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-f1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_f1') ?>

    <?= $form->field($model, 'fecha_f1') ?>

    <?= $form->field($model, 'direccion_f1') ?>

    <?= $form->field($model, 'numero_pariente') ?>

    <?php // echo $form->field($model, 'nombre_pariente') ?>

    <?php // echo $form->field($model, 'fk_ocupacion') ?>

    <?php // echo $form->field($model, 'lugar_trabajo') ?>

    <?php // echo $form->field($model, 'horario_laboral') ?>

    <?php // echo $form->field($model, 'fk_distrito') ?>

    <?php // echo $form->field($model, 'fk_alumnof1') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
