<?php

use app\models\TblTipoexpediente;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblExpediente $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-expediente-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_alumnoExpediente')->textInput() ?>

    <?= $form->field($model, 'fk_tipoExpediente')->dropDownList(
                ArrayHelper::map(TblTipoexpediente::find()->all(), 'id_tipoExpediente', 'nombre_tipoExpediente'),
                ['prompt' => 'Seleccione...']
            ) ?>

    <?= $form->field($model, 'fk_archivo')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
