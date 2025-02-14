<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblExpediente $model */

$this->title = $model->id_expediente;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-expediente-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_expediente' => $model->id_expediente], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_expediente' => $model->id_expediente], [
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
            'id_expediente',
            'fk_alumnoExpediente',
            'fk_tipoExpediente',
            'fk_archivo',
        ],
    ]) ?>

</div>
