<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblCasossuspencion $model */

$this->title = $model->id_casos;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Casossuspencions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-casossuspencion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_casos' => $model->id_casos], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_casos' => $model->id_casos], [
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
            'id_casos',
            'caso_descripcion',
            'fk_casoAlumno',
        ],
    ]) ?>

</div>
