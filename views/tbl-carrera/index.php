<?php

use app\models\TblCarrera;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblCarreraSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Carreras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-carrera-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Carrera', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_carrera',
            'nombre_carrera',
            'fk_facultad',
            'total_materias',
            'cant_horas',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblCarrera $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_carrera' => $model->id_carrera]);
                 }
            ],
        ],
        'pager' => [
            'class' => LinkPager::className(),
            'prevPageLabel' => 'Anterior',
            'nextPageLabel' => 'Siguiente',
            'maxButtonCount' => 20,
            'options' => [
                'class' => 'pagination-custom', // Clase CSS personalizada para la paginación
            ],
        ],
    ]); ?>


</div>
