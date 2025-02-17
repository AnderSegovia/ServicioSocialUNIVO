<?php

use app\assets\AppAsset;
use app\models\TblAlumno;
use app\models\TblCarrera;
use app\models\TblEstadoAlumno;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TblAlumnoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista Estudiantes';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
<div class="tbl-alumno-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('New Alumno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_alumno',
            [
                'attribute' => 'nombre_alumno',
                'format' => 'raw',
                'value' => function ($model) {
                    // Crea el enlace hacia la vista del proyecto
                    return Html::a(Html::encode($model->nombre_alumno), ['view', 'id_alumno' => $model->id_alumno]);
                },
            ],
            'codigo',
            'telefono',
            //'correo',
            [
                'attribute' => 'fk_carrera',
                'label' => 'Carrera',
                'value' => function ($model) {
                    return $model->fkCarrera ? $model->fkCarrera->nombre_carrera : 'No definido';
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'fk_carrera',
                    ArrayHelper::map(TblCarrera::find()->all(), 'id_carrera', 'nombre_carrera'),
                    [
                        'class' => 'form-control tom-select',
                        'prompt' => 'Seleccione una carrera',
                    ]
                ),
            ],
            'numero_materias',

            [
                'attribute' => 'fk_estado_alumno',
                'label' => 'Estado',
                'value' => function ($model) {
                    return $model->fkEstadoAlumno ? $model->fkEstadoAlumno->estado_alumno : 'No definido';
                },
                'filter' => ArrayHelper::map(TblEstadoAlumno::find()->all(), 'id_estado_alumno', 'estado_alumno')
            ],
            'create_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TblAlumno $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_alumno' => $model->id_alumno]);
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
    new TomSelect('.tom-select', {
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
