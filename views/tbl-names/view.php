<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblNames $model */

$this->title = $model->id_names;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tbl-names-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_names' => $model->id_names], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_names' => $model->id_names], [
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
            'id_names',
            'baseform',
            'accentsnames',
            'create_at',
        ],
    ]) ?>

</div>
