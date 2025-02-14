<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblPivote $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-pivote-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_alumno')->textInput() ?>

    <?= $form->field($model, 'fk_proyecto')->textInput() ?>

    <?= $form->field($model, 'fecha_creacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
