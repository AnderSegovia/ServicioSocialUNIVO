<?php
use yii\grid\GridView;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use app\models\TblCarrera;

?>

<div class="expedientes-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Alumno',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a(
                        $model['nombre_alumno'],
                        ['tbl-alumno/view', 'id_alumno' => $model['fk_alumnoExpediente']]
                    );
                }
            ],
            [
                'attribute' => 'codigo',
                'label' => 'Código'
            ],
            [
                'label' => 'Carrera',
                'format' => 'raw',
                'value' => function($model) {
                    $alumno = \app\models\TblAlumno::findOne($model['fk_alumnoExpediente']);
                    return $alumno ? $alumno->fkCarrera->nombre_carrera : 'Sin carrera';
                }
            ],
            [
                'attribute' => 'fk_facultad',
                'label' => 'Facultad',
                'value' => function ($model) {
                    $alumno = TblAlumno::findOne($model['fk_alumnoExpediente']);
                    return $alumno && $alumno->fkCarrera && $alumno->fkCarrera->fkFacultad
                        ? $alumno->fkCarrera->fkFacultad->nombre_facultad
                        : 'No definido';
                },
                'filter' => ArrayHelper::map(TblFacultad::find()->all(), 'id_facultad', 'nombre_facultad'),
            ]
            [
                'attribute' => 'fecha_creado',
                'label' => 'Fecha Creado'
            ],
            [
                'attribute' => 'dias_transcurridos',
                'label' => 'Días Transcurridos'
            ],
            
        ],
        'pager' => [
            'class' => LinkPager::class,
            'prevPageLabel' => 'Anterior',
            'nextPageLabel' => 'Siguiente',
            'maxButtonCount' => 50,
            'options' => [
                'class' => 'pagination-custom',
            ],
        ],
    ]); ?>
</div>
