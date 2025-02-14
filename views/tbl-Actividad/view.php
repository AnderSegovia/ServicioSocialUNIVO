<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblActividad $model */

$this->title = $model->id_actividad;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-actividad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_actividad' => $model->id_actividad], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_actividad' => $model->id_actividad], [
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
            'id_actividad',
            'nombre_actividad',
            'fk_lineamiento',
        ],
    ]) ?>

</div>
