<?php

use app\models\TblFacultad;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblFacultadSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Facultads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-facultad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Facultad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'nombre_facultad',
                'format' => 'raw',
                'value' => function ($model) {
                    // Crea el enlace hacia la vista del proyecto
                    return Html::a(Html::encode($model->nombre_facultad), ['view', 'id_facultad' => $model->id_facultad]);
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblFacultad $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_facultad' => $model->id_facultad]);
                 }
            ],
        ],
    ]); ?>


</div>
