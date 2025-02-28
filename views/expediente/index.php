<?php
use yii\grid\GridView;
use yii\bootstrap5\LinkPager;

?>

<div class="expedientes-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'fk_alumnoExpediente',
                'label' => 'Alumno'
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
