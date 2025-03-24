<?php

use app\models\TblCasossuspencion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TblCasossuspencionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Casossuspencions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-casossuspencion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Casossuspencion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_casos',
            'caso_descripcion',
            'fk_casoAlumno',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblCasossuspencion $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_casos' => $model->id_casos]);
                 }
            ],
        ],
    ]); ?>


</div>
