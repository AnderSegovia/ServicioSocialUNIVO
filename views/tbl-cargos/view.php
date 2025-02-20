<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblCargos $model */

$this->title = $model->id_cargos;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-cargos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_cargos' => $model->id_cargos], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_cargos' => $model->id_cargos], [
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
            'id_cargos',
            'cargo',
            'nombre',
        ],
    ]) ?>

</div>
