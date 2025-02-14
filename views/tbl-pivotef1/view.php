<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblPivotef1 $model */

$this->title = $model->id_pivotef1;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pivotef1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-pivotef1-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_pivotef1' => $model->id_pivotef1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_pivotef1' => $model->id_pivotef1], [
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
            'id_pivotef1',
            'fk_f1',
            'fk_dia',
            'fk_turno',
        ],
    ]) ?>

</div>
