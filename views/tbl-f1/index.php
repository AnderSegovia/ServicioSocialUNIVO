<?php

use app\assets\AppAsset;
use app\models\TblCarrera;
use app\models\TblDepartamentos;
use app\models\TblDistritos;
use app\models\TblEstadoAlumno;
use app\models\TblF1;
use app\models\TblMunicipios;
use app\models\TblOcupacion;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TblF1Search $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Fichas F1';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="tbl-f1-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create F1', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'id_f1',
            //'fecha_f1',
            [
                'attribute' => 'nombre_alumno',
                'label' => 'Nombre Alumno',
                'format' => 'raw', // Necesario para renderizar HTML en la celda
                'value' => function ($model) {
                    if ($model->fkAlumnof1) {
                        return Html::a(
                            Html::encode($model->fkAlumnof1->nombre_alumno),
                            ['view', 'id_f1' => $model->id_f1], // Ajusta la ruta según tu configuración
                            //['target' => '_blank'] //Opcional: abre el enlace en una nueva pestaña
                        );
                    } else {
                        return '-';
                    }
                },
            ],
            
            [
                'attribute' => 'codigo',
                'label' => 'Codigo',
                'format' => 'raw', // Necesario para renderizar HTML en la celda
                'value' => function ($model) {
                    if ($model->fkAlumnof1) {
                        return Html::a(Html::encode($model->fkAlumnof1->codigo),
                            ['tbl-alumno/view', 'id_alumno' => $model->fkAlumnof1->id_alumno], // Ajusta la ruta según tu configuración
                            ['target' => '_blank'] //Opcional: abre el enlace en una nueva pestaña
                        );
                    }
                },
            ],
            [
                'attribute' => 'telefono',
                'label' => 'Telefono',
                'value' => function ($model) {
                    return $model->fkAlumnof1 ? $model->fkAlumnof1->telefono : 'No definido';
                },
            ],
            [
                'attribute' => 'fk_carrera',
                'label' => 'Carrera',
                'value' => function ($model) {
                    return $model->fkAlumnof1 && $model->fkAlumnof1->fkCarrera
                        ? $model->fkAlumnof1->fkCarrera->nombre_carrera
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
            //'cant_materias',
            'direccion_f1',
            [
                'attribute' => 'fk_distritos',
                'label' => 'Distrito',
                'value' => function ($model) {
                    return $model->fkDistrito ? $model->fkDistrito->nombre_distrito : 'No definido';
                },
                    'filter' => Html::activeDropDownList(
                    $searchModel,
                    'fk_distrito',
                    ArrayHelper::map(TblDistritos::find()->all(), 'id_distrito', 'nombre_distrito'),
                    [
                    'class' => 'form-control tom-select',
                    'id' => 'institucion-select',
                    'prompt' => 'Seleccione...',
                    ]
                ),
            ],
            [
                'attribute' => 'fk_municipio',
                'label' => 'Municipio',
                'value' => function ($model) {
                    return $model->fkDistrito && $model->fkDistrito->fkMunicipio
                        ? $model->fkDistrito->fkMunicipio->nombre_municipio
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblMunicipios::find()->all(), 'id_municipio', 'nombre_municipio'),
            ],
            [
                'attribute' => 'fk_departamento',
                'label' => 'Departamento',
                'value' => function ($model) {
                    return $model->fkDistrito && $model->fkDistrito->fkMunicipio->fkDepartamento
                        ? $model->fkDistrito->fkMunicipio->fkDepartamento->nombre_departamento
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblDepartamentos::find()->all(), 'id_departamento', 'nombre_departamento'),
            ],
            //'numero_pariente',
            //'nombre_pariente',
            [
                'attribute' => 'fk_ocupacion',
                'label' => 'Ocupacion',
                'value' => function ($model) {
                    return $model->fkOcupacion ? $model->fkOcupacion->nombre_ocupacion : 'No definido';
                },
                'filter' => ArrayHelper::map(TblOcupacion::find()->all(), 'id_ocupacion', 'nombre_ocupacion'),
            ],
            [
                'attribute' => 'fk_estado_alumno',
                'label' => 'Estado',
                'value' => function ($model) {
                    return $model->fkAlumnof1 && $model->fkAlumnof1->fkEstadoAlumno
                        ? $model->fkAlumnof1->fkEstadoAlumno->estado_alumno
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblEstadoAlumno::find()->all(), 'id_estado_alumno', 'estado_alumno'),
            ],
            //'lugar_trabajo',
            //'horario_laboral',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblF1 $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_f1' => $model->id_f1]);
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