<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblInstituciones $model */

$this->title = $model->id_institucion;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Instituciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-instituciones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_institucion' => $model->id_institucion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_institucion' => $model->id_institucion], [
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
            'id_institucion',
            'nombre_institucion',
            'fk_actividad',
            'nombre_encargado',
            'titulo',
            'cargo',
            'saludo',
            'telefono_encargado',
            'correo_encargado',
            'fk_distritoInst',
        ],
    ]) ?>

</div>
