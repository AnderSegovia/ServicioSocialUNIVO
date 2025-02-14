<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblPivotef1 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-pivotef1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_f1')->textInput() ?>

    <?= $form->field($model, 'fk_dia')->textInput() ?>

    <?= $form->field($model, 'fk_turno')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
