<?php

use app\assets\AppAsset;
use app\models\TblActividad;
use app\models\TblCarrera;
use app\models\TblEstadoProyecto;
use app\models\TblFacultad;
use app\models\TblImpacto;
use app\models\TblInstituciones;
use app\models\TblLineamiento;
use app\models\TblProyecto;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TblProyectoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Proyectos';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="tbl-proyecto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-10">
        <p>
        <?= Html::a('New Proyecto', ['create'], ['class' => 'btn btn-success']) ?>
         </p>      
          </div>  
            <div class="col-md-2">
            <p>
            <?= Html::a('Generar Reporte', Url::toRoute(array_merge(['report'], Yii::$app->request->queryParams)), ['class' => 'btn btn-primary']) ?>
            </p>
            </div>
        </div>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //  'id_proyecto',
            [
                'attribute' => 'nombre_proyecto',
                'format' => 'raw',
                'value' => function ($model) {
                    // Crea el enlace hacia la vista del proyecto
                    return Html::a(Html::encode($model->nombre_proyecto), ['view', 'id_proyecto' => $model->id_proyecto]);
                },
            ],
            'numero_registro',
            [
                'attribute' => 'fecha_inicio',
                'value' => 'fecha_inicio',
                'filter' => '<div class="form-group">' . 
                            Html::input('date', 'TblProyectoSearch[fecha_inicio_from]', $searchModel->fecha_inicio_from, ['class' => 'form-control']) . 
                            Html::input('date', 'TblProyectoSearch[fecha_inicio_to]', $searchModel->fecha_inicio_to, ['class' => 'form-control']) . 
                            '</div>',
                'format' => 'raw',
            ],
                        //'fk_impacto',
                        [
                            'attribute' => 'fk_institucion',
                            'label' => 'Institución',
                            'value' => function ($model) {
                                return $model->fkInstitucion ? $model->fkInstitucion->nombre_institucion : 'No definido';
                            },
                                'filter' => Html::activeDropDownList(
                                    $searchModel,
                                    'fk_institucion',
                                    ArrayHelper::map(TblInstituciones::find()->all(), 'id_institucion', 'nombre_institucion'),
                                    [
                                        'class' => 'form-control tom-select',
                                        'id' => 'institucion-select',
                                        'prompt' => 'Seleccione...',
                                    ]
                            ),
                        ],
                        [
                            'attribute' => 'fk_facultad',
                            'label' => '-------Facultad ------',
                            'value' => function ($model) {
                                return $model->fkCarreraProyecto && $model->fkCarreraProyecto->fkFacultad
                                    ? $model->fkCarreraProyecto->fkFacultad->nombre_facultad
                                    : 'No definido';
                            },
                            'filter' => ArrayHelper::map(TblFacultad::find()->all(), 'id_facultad', 'nombre_facultad'),
                        ],
            [
                'attribute' => 'fk_carrera_proyecto',
                'label' => 'Carrera',
                'value' => function ($model) {
                    return $model->fkCarreraProyecto ? $model->fkCarreraProyecto->nombre_carrera : 'No definido';
                },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'fk_carrera_proyecto',
                        ArrayHelper::map(TblCarrera::find()->all(), 'id_carrera', 'nombre_carrera'),
                        [
                            'class' => 'form-control tom-select',
                            'id' => 'carrera-select',
                            'prompt' => 'Seleccione...',
                        ]   
                    ),
                ],
                [
                'attribute' => 'fk_lineamiento',
                'label' => 'Linea',
                'value' => function ($model) {
                    return $model->fkInstitucion && $model->fkInstitucion->fkActividad->fkLineamiento
                        ? $model->fkInstitucion->fkActividad->fkLineamiento->nombre_lineamiento
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblLineamiento::find()->all(), 'id_lineamiento', 'nombre_lineamiento'),
            ],
            [
                'attribute' => 'fk_actividad',
                'label' => 'Actividad',
                'value' => function ($model) {
                    return $model->fkInstitucion && $model->fkInstitucion->fkActividad
                        ? $model->fkInstitucion->fkActividad->nombre_actividad
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblActividad::find()->all(), 'id_actividad', 'nombre_actividad'),
            ],
            [
                'attribute' => 'fk_estado_proyecto',
                'label' => 'Estado',
                'value' => function ($model) {
                    return $model->fkEstadoProyecto ? $model->fkEstadoProyecto->estado_proyecto : 'No definido';
                },
                'filter' => ArrayHelper::map(TblEstadoProyecto::find()->all(), 'id_estado_proyecto', 'estado_proyecto'),
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblProyecto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_proyecto' => $model->id_proyecto]);
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
<?php
$this->registerJs("
    new TomSelect('#institucion-select', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });

    new TomSelect('#carrera-select', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });
");
?>