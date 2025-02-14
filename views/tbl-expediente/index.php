<?php

use app\assets\AppAsset;
use app\models\TblCarrera;
use app\models\TblExpediente;
use app\models\TblFacultad;
use app\models\TblInstituciones;
use app\models\TblTipoexpediente;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TblExpendienteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Expedientes';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="tbl-expediente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_expediente',
            //'fk_alumnoExpediente',
            //'fk_tipoExpediente',

            [
                'attribute' => 'fk_archivo',
                'label' => 'Archivo',
                'value' => function ($model) {
                    if ($model->fkArchivo) {
                        $nombreArchivo = Html::a(
                            $model->fkArchivo->nombre_archivo,
                            ['carta/ver-pdf', 'nombre' => $model->fkArchivo->nombre_archivo],
                            ['target' => '_blank']
                        );
                        return $nombreArchivo . ' --> ' . $model->fkArchivo->fecha_creado;
                    }
                    return 'No definido';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'fk_facultad',
                'label' => 'Facultad',
                'value' => function ($model) {
                    return $model->fkAlumnoExpediente && $model->fkAlumnoExpediente->fkCarrera->fkFacultad
                        ? $model->fkAlumnoExpediente->fkCarrera->fkFacultad->nombre_facultad
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblFacultad::find()->all(), 'id_facultad', 'nombre_facultad'),
            ],
            [
                'attribute' => 'fk_carrera',
                'label' => 'Carrera',
                'value' => function ($model) {
                    return $model->fkAlumnoExpediente && $model->fkAlumnoExpediente->fkCarrera
                        ? $model->fkAlumnoExpediente->fkCarrera->nombre_carrera
                        : 'No definido';
                },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'fk_carrera',
                        ArrayHelper::map(TblCarrera::find()->all(), 'id_carrera', 'nombre_carrera'),
                        [
                            'class' => 'form-control tom-select',
                            'id' => 'carrera-select',
                            'prompt' => 'Seleccione...',
                        ]
                ),
            ],
            [
                'attribute' => 'fk_institucionArchivo',
                'label' => 'Institución',
                'value' => function ($model) {
                    return $model->fkArchivo && $model->fkArchivo->fkInstitucionArchivo
                        ? $model->fkArchivo->fkInstitucionArchivo->nombre_institucion
                        : 'No definido';
                },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'fk_institucionArchivo',
                        ArrayHelper::map(TblInstituciones::find()->all(), 'id_institucion', 'nombre_institucion'),
                        [
                            'class' => 'form-control tom-select',
                            'id' => 'institucion-select',
                            'prompt' => 'Seleccione...',
                        ]
                ),
            ],
            [
                'attribute' => 'fk_tipoExpediente',
                'label' => 'Tipo',
                'value' => function ($model) {
                    return $model->fkTipoExpediente ? $model->fkTipoExpediente->nombre_tipoExpediente : 'No definido';
                },
                'filter' => ArrayHelper::map(TblTipoexpediente::find()->all(), 'id_tipoExpediente', 'nombre_tipoExpediente')
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblExpediente $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_expediente' => $model->id_expediente]);
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