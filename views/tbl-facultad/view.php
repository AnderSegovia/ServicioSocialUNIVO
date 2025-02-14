<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblFacultad $model */

$this->title = $model->id_facultad;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Facultads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-facultad-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_facultad' => $model->id_facultad], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_facultad' => $model->id_facultad], [
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
            'id_facultad',
            'nombre_facultad',
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-12">
            <h2>Carreras</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->tblCarreras as $carrera): ?>
                            <tr>
                                <td><?= Html::a(Html::encode($carrera->nombre_carrera), ['tbl-carrera/view', 'id_carrera' => $carrera->id_carrera]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
