<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoProyecto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-estado-proyecto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'estado_proyecto')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
