<?php

use app\models\TblCargos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblCargosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Cargos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-cargos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Cargos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_cargos',
            'cargo',
            'nombre',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblCargos $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_cargos' => $model->id_cargos]);
                 }
            ],
        ],
    ]); ?>


</div>
