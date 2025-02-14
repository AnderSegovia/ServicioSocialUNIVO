<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoAlumno $model */

$this->title = $model->id_estado_alumno;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Estado Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-estado-alumno-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_estado_alumno' => $model->id_estado_alumno], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_estado_alumno' => $model->id_estado_alumno], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_estado_alumno',
            'estado_alumno',
        ],
    ]) ?>

</div>
