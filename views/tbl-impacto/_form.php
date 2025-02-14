<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblImpacto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-impacto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_impacto')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
