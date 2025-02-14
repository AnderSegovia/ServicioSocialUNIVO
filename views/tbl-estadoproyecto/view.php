<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoProyecto $model */

$this->title = $model->id_estado_proyecto;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Estado Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-estado-proyecto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_estado_proyecto' => $model->id_estado_proyecto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_estado_proyecto' => $model->id_estado_proyecto], [
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
            'id_estado_proyecto',
            'estado_proyecto',
        ],
    ]) ?>

</div>
