<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoAlumno $model */

$this->title = 'Create Tbl Estado Alumno';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Estado Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-estado-alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
