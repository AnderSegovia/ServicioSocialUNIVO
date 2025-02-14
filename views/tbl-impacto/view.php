<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblImpacto $model */

$this->title = $model->id_impacto;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Impactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-impacto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_impacto' => $model->id_impacto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_impacto' => $model->id_impacto], [
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
            'id_impacto',
            'nombre_impacto',
        ],
    ]) ?>

</div>
