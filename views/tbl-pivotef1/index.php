<?php

use app\models\TblPivotef1;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblPivotef1Search $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Pivotef1s';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-pivotef1-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Pivotef1', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pivotef1',
            'fk_f1',
            'fk_dia',
            'fk_turno',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblPivotef1 $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_pivotef1' => $model->id_pivotef1]);
                 }
            ],
        ],
    ]); ?>


</div>
