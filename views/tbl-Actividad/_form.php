<?php

use app\models\TblLineamiento;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblActividad $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tbl-actividad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_actividad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_lineamiento')->dropDownList(
                ArrayHelper::map(TblLineamiento::find()->all(), 'id_lineamiento', 'nombre_lineamiento'),
                ['prompt' => 'Seleccione...']
            ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
