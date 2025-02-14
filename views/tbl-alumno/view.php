<?php

use app\models\TblArchivos;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblAlumno */

$this->title = $model->nombre_alumno;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="tbl-alumno-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_alumno' => $model->id_alumno], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_alumno' => $model->id_alumno], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="detail-view">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id_alumno',
                        'nombre_alumno',
                        'codigo',
                        'telefono',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-view">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'correo',
                        [
                            'attribute' => 'fk_carrera',
                            'value' => function ($model) {
                                return $model->fkCarrera ? $model->fkCarrera->nombre_carrera : 'Estado no definido';
                            },
                        ],
                        [
                            'attribute' => 'fk_estado_alumno',
                            'value' => function ($model) {
                                return $model->fkEstadoAlumno ? $model->fkEstadoAlumno->estado_alumno : 'Estado no definido';
                            },
                        ],
                        'numero_materias',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Proyectos Asignados</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre Proyecto</th>
                            <th>Número de Registro</th>
                            <th>Horario</th>
                            <th>Fecha de Inicio</th>
                            <th>Fecha de Fin</th>
                            <th>Cantidad de Beneficiados</th>
                            <th>Cantidad de Inversión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->proyectosAsignados as $index => $proyecto): ?>
                            <tr>
                                <td><?= Html::a(Html::encode($proyecto->nombre_proyecto), ['tbl-proyecto/view', 'id_proyecto' => $proyecto->id_proyecto]) ?></td>
                                <td><?= Html::encode($proyecto->numero_registro) ?></td>
                                <td><?= Html::encode($proyecto->horario) ?></td>
                                <td><?= Yii::$app->formatter->asDate($proyecto->fecha_inicio) ?></td>
                                <td><?= Yii::$app->formatter->asDate($proyecto->fecha_fin) ?></td>
                                <td><?= Html::encode($proyecto->cant_beneficiados) ?></td>
                                <td><?= Html::encode($proyecto->cant_inversion) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Expediente</h2>
            <div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Carta de Asignacion</th>
            <th>Plan de Trabajo</th>
            <th>Memoria de Labores</th>
            <th>Constancia Finalizacion</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>
                <?php if (isset($expedientesPorTipo[1])): ?>
                    <?php foreach ($expedientesPorTipo[1] as $expediente): ?>
                        <?php
                        $archivo = TblArchivos::findOne($expediente->fk_archivo);
                        if ($archivo) {
                            echo Html::a(
                                $archivo->nombre_archivo,
                                ['carta/ver-pdf', 'nombre' => $archivo->nombre_archivo],
                                ['target' => '_blank']
                            ) . ' --> ' . $archivo->fecha_creado . '<br>';
                        } else {
                            echo 'Archivo no encontrado';
                        }
                        
                        ?>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    No hay datos
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($expedientesPorTipo[2])): ?>
                    <?php foreach ($expedientesPorTipo[2] as $expediente): ?>
                        <?php
                        $archivo = TblArchivos::findOne($expediente->fk_archivo);
                        if ($archivo) {
                            echo Html::a(
                                $archivo->nombre_archivo,
                                ['carta/ver-pdf', 'nombre' => $archivo->nombre_archivo],
                                ['target' => '_blank']
                            ) . ' --> ' . $archivo->fecha_creado . '<br>';
                        } else {
                            echo 'Archivo no encontrado';
                        }
                        
                        ?>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    No hay datos
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($expedientesPorTipo[3])): ?>
                    <?php foreach ($expedientesPorTipo[3] as $expediente): ?>
                        <?php
                        $archivo = TblArchivos::findOne($expediente->fk_archivo);
                        if ($archivo) {
                            echo Html::a(
                                $archivo->nombre_archivo,
                                ['carta/ver-pdf', 'nombre' => $archivo->nombre_archivo],
                                ['target' => '_blank']
                            ) . ' --> ' . $archivo->fecha_creado . '<br>';
                        } else {
                            echo 'Archivo no encontrado';
                        }
                        
                        ?>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    No hay datos
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($expedientesPorTipo[4])): ?>
                    <?php foreach ($expedientesPorTipo[4] as $expediente): ?>
                        <?php
                        $archivo = TblArchivos::findOne($expediente->fk_archivo);
                        if ($archivo) {
                            echo Html::a(
                                $archivo->nombre_archivo,
                                ['carta/ver-pdf', 'nombre' => $archivo->nombre_archivo],
                                ['target' => '_blank']
                            ) . ' --> ' . $archivo->fecha_creado . '<br>';
                        } else {
                            echo 'Archivo no encontrado';
                        }
                        
                        ?>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    No hay datos
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>


            </div>
        </div>
    </div>


</div>
