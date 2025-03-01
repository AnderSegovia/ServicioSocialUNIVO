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
                    // Genera un enlace al perfil del alumno utilizando solo el nombre
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
                    // Accede a la relación de la carrera a través del modelo del alumno
                    $alumno = \app\models\TblAlumno::findOne($model['fk_alumnoExpediente']);
                    return $alumno ? $alumno->fkCarrera->nombre_carrera : 'Sin carrera';
                }
            ],
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
