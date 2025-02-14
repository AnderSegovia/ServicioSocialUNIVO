<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblCarrera $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-carrera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_carrera')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_facultad')->textInput() ?>

    <?= $form->field($model, 'total_materias')->textInput() ?>

    <?= $form->field($model, 'cant_horas')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
