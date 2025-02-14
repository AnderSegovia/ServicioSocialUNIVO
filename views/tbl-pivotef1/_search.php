<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblPivotef1Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-pivotef1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pivotef1') ?>

    <?= $form->field($model, 'fk_f1') ?>

    <?= $form->field($model, 'fk_dia') ?>

    <?= $form->field($model, 'fk_turno') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
