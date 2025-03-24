<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblAlumno $model */

$this->title = 'Update Alumno: ' . $model->id_alumno;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_alumno, 'url' => ['view', 'id_alumno' => $model->id_alumno]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-alumno-update">

    <h1><?= Html::encode( $model->nombre_alumno) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'casoSuspension' => $casoSuspension,
    ]) ?>

</div>
