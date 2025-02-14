<?php

use app\models\TblDistritos;
use app\models\TblActividad;
use app\models\TblInstituciones;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TblInstitucionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tbl Instituciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-instituciones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tbl Instituciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_institucion',
            'nombre_institucion',
            //'fk_actividad',
	[
                'attribute' => 'fk_actividad',
                'label' => 'Atividad',
                'value' => function ($model) {
                    return $model->fkActividad ? $model->fkActividad->nombre_actividad : 'No definido';
                },
                'filter' => ArrayHelper::map(TblActividad::find()->all(), 'id_actividad', 'nombre_actividad')
            ],
            'nombre_encargado',
            'titulo',
            //'cargo',
            //'saludo',
            //'telefono_encargado',
            //'correo_encargado',
            //'fk_distritoInst',
            [
                'attribute' => 'fk_distritoInst',
                'label' => 'Distrito',
                'value' => function ($model) {
                    return $model->fkDistritoInst ? $model->fkDistritoInst->nombre_distrito : 'No definido';
                },
                'filter' => ArrayHelper::map(TblDistritos::find()->all(), 'id_distrito', 'nombre_distrito')
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblInstituciones $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_institucion' => $model->id_institucion]);
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
