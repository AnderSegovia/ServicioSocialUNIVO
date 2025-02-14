<?php

use app\models\TblImpacto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblImpactoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Impactos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-impacto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Impacto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_impacto',
            'nombre_impacto',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblImpacto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_impacto' => $model->id_impacto]);
                 }
            ],
        ],
    ]); ?>


</div>
