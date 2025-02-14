<?php

use app\models\TblEstadoAlumno;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoAlumnoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Estado Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-estado-alumno-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Estado Alumno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_estado_alumno',
            'estado_alumno',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblEstadoAlumno $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_estado_alumno' => $model->id_estado_alumno]);
                 }
            ],
        ],
    ]); ?>


</div>
