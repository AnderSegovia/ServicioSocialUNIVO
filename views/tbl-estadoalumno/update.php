<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoAlumno $model */

$this->title = 'Update Tbl Estado Alumno: ' . $model->id_estado_alumno;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Estado Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_estado_alumno, 'url' => ['view', 'id_estado_alumno' => $model->id_estado_alumno]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-estado-alumno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
