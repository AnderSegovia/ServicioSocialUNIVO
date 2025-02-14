<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblExpendienteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-expediente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_expediente') ?>

    <?= $form->field($model, 'fk_alumnoExpediente') ?>

    <?= $form->field($model, 'fk_tipoExpediente') ?>

    <?= $form->field($model, 'fk_archivo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
