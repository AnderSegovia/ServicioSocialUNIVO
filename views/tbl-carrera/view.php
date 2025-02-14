<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblCarrera $model */

$this->title = $model->id_carrera;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-carrera-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_carrera' => $model->id_carrera], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_carrera' => $model->id_carrera], [
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
            'id_carrera',
            'nombre_carrera',
            'fk_facultad',
            'total_materias',
            'cant_horas',
        ],
    ]) ?>

</div>
