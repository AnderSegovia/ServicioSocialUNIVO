<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblNames $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-names-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'baseform')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accentsnames')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
