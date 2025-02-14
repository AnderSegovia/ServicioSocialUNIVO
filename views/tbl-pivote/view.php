<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblPivote $model */

$this->title = $model->id_pivote;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pivotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-pivote-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_pivote' => $model->id_pivote], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_pivote' => $model->id_pivote], [
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
            'id_pivote',
            'fk_alumno',
            'fk_proyecto',
            'fecha_creacion',
        ],
    ]) ?>

</div>
