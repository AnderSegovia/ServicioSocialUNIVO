<?php
use app\models\TblDias;
use app\models\TblTurnos;
use app\models\TblArchivos;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblAlumno */

$this->title = $model->nombre_alumno;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$dias = TblDias::find()->all();
$turnos = TblTurnos::find()->all();
$checked = [];
foreach ($pivotRecords as $record) {
    $checked[$record->fk_dia][$record->fk_turno] = true;
}

?>
<style>
    /* Estilos personalizados para los checkboxes deshabilitados */
    input[type="checkbox"]:disabled {
        cursor: not-allowed; /* Indica que no son interactivos */
    }

    /* Estilo para checkboxes seleccionados y deshabilitados */
    input[type="checkbox"]:checked:disabled {
        background-color: #007bff; /* Fondo azul */
        border: 2px solid #007bff; /* Borde azul */
    }

    /* Estilo para el checkmark dentro del checkbox cuando está seleccionado */
    input[type="checkbox"]:checked:disabled::before {
        content: '✔'; /* Checkmark */
        color: white; /* Color del checkmark */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 12px;
        font-weight: bold;
    }

    /* Estilos básicos para los checkboxes para que mantengan su apariencia */
    input[type="checkbox"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 16px;
        height: 16px;
        border: 2px solid #ccc;
        border-radius: 3px;
        background-color: #f8f9fa;
        position: relative;
        margin-right: 5px;
    }

    /* Estilo para el checkbox deshabilitado pero sin seleccionar */
    input[type="checkbox"]:disabled:not(:checked) {
        background-color: #f8f9fa;
        border-color: #ccc;
    }
</style>

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


<?php if ($f1Model): ?> <!-- Verifica si hay datos en TblF1 -->
    <h3>Datos F1 del Estudiante</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="detail-view">
                <?= DetailView::widget([
                    'model' => $f1Model,
                    'attributes' => [
                        'id_f1',
                        'fecha_f1',
                        [
                            'attribute' => 'fk_ocupacion',
                            'label' => 'Ocupación',
                            'value' => function ($f1Model) {
                                return $f1Model->fkOcupacion ? $f1Model->fkOcupacion->nombre_ocupacion : 'Sin asignar';
                            },
                        ],
                        'lugar_trabajo',
                        'horario_laboral',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-view">
                <?= DetailView::widget([
                    'model' => $f1Model,
                    'attributes' => [
                        'direccion_f1',
                        [
                            'attribute' => 'fk_distrito',
                            'label' => 'Distrito',
                            'value' => function ($f1Model) {
                                return $f1Model->fkDistrito ? $f1Model->fkDistrito->nombre_distrito : 'Sin asignar';
                            },
                        ],
                        [
                            'attribute' => 'fk_distrito',
                            'label' => 'Municipio',
                            'value' => function ($f1Model) {
                                return $f1Model->fkDistrito ? $f1Model->fkDistrito->fkMunicipio->nombre_municipio : 'Sin asignar';
                            },
                        ],
                        [
                            'attribute' => 'fk_distrito',
                            'label' => 'Departamento',
                            'value' => function ($f1Model) {
                                return $f1Model->fkDistrito ? $f1Model->fkDistrito->fkMunicipio->fkDepartamento->nombre_departamento : 'Sin asignar';
                            },
                        ],
                        'numero_pariente',
                        'nombre_pariente',

                    ],
                ]) ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>No hay información de F1 disponible para este estudiante.</p>
<?php endif; ?>


       
<?php if (!empty($dias) && !empty($turnos)) : ?>
    <div id="tabla-dias-turnos" class="mt-5">
        <h3>Horarios SSE</h3>
        <div class="checkbox-container"></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php foreach ($dias as $dia) : ?>
                        <th>
                            <label>
                                <input type="checkbox" class="check-all-turnos" data-dia="<?= $dia->id_dia ?>" name="dias[]" value="<?= $dia->id_dia ?>" <?= isset($checked[$dia->id_dia]) && count($checked[$dia->id_dia]) == count($turnos) ? 'checked' : '' ?> disabled>
                                <?= Html::encode($dia->nombre_dia) ?>
                            </label>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnos as $turno) : ?>
                    <tr>
                        <?php foreach ($dias as $dia) : ?>
                            <td>
                                <label>
                                    <input type="checkbox" name="turno-dia[<?= $dia->id_dia ?>][]" value="<?= $turno->id_turno ?>" class="turno-checkbox dia-<?= $dia->id_dia ?>" data-dia="<?= $dia->id_dia ?>" <?= isset($checked[$dia->id_dia][$turno->id_turno]) ? 'checked' : '' ?> disabled>
                                    <?= Html::encode($turno->nombre_turno) ?>
                                </label>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info mt-3 text-center">
        <strong>No hay horarios asignados para este alumno.</strong>
    </div>
<?php endif; ?>


    </div>

            </div>
        </div>
    </div>
</div>
