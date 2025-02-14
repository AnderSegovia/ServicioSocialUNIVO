<?php

use app\models\TblActividad;
use app\models\TblLineamiento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TblActividadSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Actividads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-actividad-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Actividad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_actividad',
            'nombre_actividad',

            'descripcion',
            [
                'attribute' => 'fk_lineamiento',
                'label' => 'Lineamiento',
                'value' => function ($model) {
                    return $model->fkLineamiento ? $model->fkLineamiento->nombre_lineamiento : 'No definido';
                },
                'filter' => ArrayHelper::map(TblLineamiento::find()->all(), 'id_lineamiento', 'nombre_lineamiento'),
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblActividad $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_actividad' => $model->id_actividad]);
                 }
            ],
        ],
    ]); ?>


</div>
