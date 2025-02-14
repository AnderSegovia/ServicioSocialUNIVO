<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblAlumno $model */

$this->title = 'Create Tbl Alumno';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
