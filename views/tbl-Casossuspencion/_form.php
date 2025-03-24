<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblCasossuspencion $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-casossuspencion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'caso_descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_casoAlumno')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
