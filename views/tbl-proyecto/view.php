<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TblProyecto */

$this->title = 'Proyecto';
$this->params['breadcrumbs'][] = ['label' => 'Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="tbl-proyecto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_proyecto' => $model->id_proyecto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_proyecto' => $model->id_proyecto], [
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
                        'id_proyecto',
                        'nombre_proyecto',
                        'numero_registro',
                        'horario',
                        'fecha_inicio:date',
                        'fecha_fin:date',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="detail-view">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'cant_beneficiados',
                        'cant_inversion',
                        [
                            'attribute' => 'fk_estado_proyecto',
                            'value' => function ($model) {
                                return $model->fkEstadoProyecto ? $model->fkEstadoProyecto->estado_proyecto : 'Estado no definido';
                            },
                        ],
                        [
                            'attribute' => 'fk_institucion',
                            'value' => function ($model) {
                                return $model->fkInstitucion ? $model->fkInstitucion->nombre_institucion : 'Sin asignar';
                            },
                        ],
                        [
                            'attribute' => 'fk_impacto',
                            'value' => function ($model) {
                                return $model->fkImpacto ? $model->fkImpacto->nombre_impacto : 'No definido';
                            },
                        ],
                        [
                            'attribute' => 'fk_carrera_proyecto',
                            'value' => function ($model) {
                                return $model->fkCarreraProyecto ? $model->fkCarreraProyecto->nombre_carrera : 'No definido';
                            },
                        ],
                        
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

        <div class="row">
        <div class="col-md-11">
            <h2>Estudiantes Asignados</h2>
        </div>  
            <div class="col-md-1">
            <?= Html::button('Agregar', [
            'class' => 'btn btn-primary',
            'id' => 'modalButton'
            ]); ?>
            </div>
        </div>

            <div class="table-responsive">
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Carrera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->alumnos as $alumno): ?>
                            <tr>
                                <td><?= Html::a(Html::encode($alumno->nombre_alumno), ['tbl-alumno/view', 'id_alumno' => $alumno->id_alumno]) ?></td>
                                <td><?= Html::encode($alumno->codigo) ?></td>
                                <td><?= Html::encode($alumno->telefono) ?></td>
                                <td><?= Html::encode($alumno->correo) ?></td>
                                <td><?= Html::encode($alumno->fkEstadoAlumno ? $alumno->fkEstadoAlumno->estado_alumno : 'Estado no definido') ?></td>
                                <td><?= Html::encode($alumno->fkCarrera ? $alumno->fkCarrera->nombre_carrera : 'Carrera no definida') ?></td>
                                <td>       
                                                <?= Html::a('<i class="fas fa-trash-alt"></i>', ['delete-pivote', 'id_alumno' => $alumno->id_alumno, 'id_proyecto' => $model->id_proyecto], [
                'class' => 'btn btn-danger btn-icon',
                'data' => [
                    'confirm' => '¿Estás seguro de que deseas eliminar este estudiante del proyecto?',
                    'method' => 'post',
                ],
                'title' => 'Eliminar'
            ]) ?>
        </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
Modal::begin([
    'title' => 'Buscar Estudiante', // Título del modal
    'id' => 'modal',
    'size' => Modal::SIZE_LARGE, // Tamaño del modal
    'options' => ['tabindex' => false] // Importante para evitar problemas con Select2
]);

echo "<div id='modalContent'>";

// Campo de texto para búsqueda
echo Html::label('Buscar Estudiante:', 'search');
echo Html::textInput('search', '', ['class' => 'form-control', 'id' => 'search-input', 'placeholder' => 'Buscar por código o nombre...']);

// Dropdown para seleccionar estudiante
echo Html::label('Seleccione un estudiante:', 'estudiante');
echo Html::dropDownList('id_alumno', null, [], ['class' => 'form-control', 'prompt' => 'Seleccione un estudiante...', 'id' => 'dropdown-estudiantes']);

// Formulario para agregar estudiante
echo Html::beginForm(['tbl-proyecto/agregar-estudiante', 'id_proyecto' => $model->id_proyecto], 'post');
echo Html::hiddenInput('id_proyecto', $model->id_proyecto);
echo Html::hiddenInput('id_alumno', '', ['id' => 'selected-alumno-id']); // Campo oculto para el ID del alumno seleccionado
echo Html::submitButton('Agregar', ['class' => 'btn btn-success', 'style' => 'margin-top: 10px;', 'id' => 'agregar-btn']);
echo Html::endForm();

echo "</div>";

Modal::end();
?>



</div>

<?php
$script = <<< JS
$('#modalButton').on('click', function() {
    $('#modal').modal('show');
});

$('#search-input').on('keyup', function() {
    var search = $(this).val();
    $.ajax({
        url: 'filtrar-estudiantes', // URL de la acción en el controlador
        type: 'get',
        data: { search: search },
        success: function(data) {
            var options = '';
            
            if (search.trim() === '') {
                options += '<option value="">Seleccione un estudiante...</option>';
                // Mostrar todos los estudiantes
                for (var id in data) {
                    options += '<option value="' + id + '">' + data[id] + '</option>';
                }
                $('#dropdown-estudiantes').val('');
                $('#selected-alumno-id').val('');
            } else if (Object.keys(data).length > 0) {
                // Mostrar opciones filtradas
                for (var id in data) {
                    options += '<option value="' + id + '">' + data[id] + '</option>';
                }
                // Seleccionar automáticamente la primera opción si hay resultados
                $('#dropdown-estudiantes').val(Object.keys(data)[0]);
                $('#selected-alumno-id').val(Object.keys(data)[0]);
            } else {
                // No hay coincidencias
                options += '<option value="">Sin coincidencias</option>';
                $('#dropdown-estudiantes').val(''); 
                $('#selected-alumno-id').val('');
            }
            
            $('#dropdown-estudiantes').html(options);
        }
    });
});

// Actualizar el campo oculto cuando se selecciona un estudiante
$('#dropdown-estudiantes').on('change', function() {
    var selectedAlumnoId = $(this).val();
    $('#selected-alumno-id').val(selectedAlumnoId);
});

JS;
$this->registerJs($script);
?>
