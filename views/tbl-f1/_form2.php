<?php

use app\assets\AppAsset;
use app\models\TblAlumno;
use app\models\TblDepartamentos;
use app\models\TblDias;
use app\models\TblDistritos;
use app\models\TblMunicipios;
use app\models\TblOcupacion;
use app\models\TblTurnos;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblF1 $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$id_alumno = isset($_GET['id_alumno']) ? $_GET['id_alumno'] : null;
$dias = TblDias::find()->all();
$turnos = TblTurnos::find()->all();
?>


<div class="tbl-f1-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <!-- Primera columna -->
        <div class="col-md-6">

        <?= $form->field($model, 'fk_alumnof1')->dropDownList(
ArrayHelper::map(TblAlumno::find()->all(), 'id_alumno', function($model) {
    return $model->codigo . ' - ' . $model->nombre_alumno ;
}),
[
    'prompt' => 'Seleccione...',
    'class' => 'form-control tom-select-carrera', // Clase personalizada para Tom Select
    'options' => [
        $id_alumno => ['selected' => true] // Preseleccionar el ID del alumno creado
    ],
        'disabled' => true,
]
) ?>

    <?= $form->field($model, 'numero_pariente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre_pariente')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fk_ocupacion')->dropDownList(
            ArrayHelper::map(TblOcupacion::find()->all(), 'id_ocupacion', 'nombre_ocupacion'),
            [
                'prompt' => 'Seleccione...',
                'id' => 'ocupacionId', // ID para identificar el campo de selección de ocupación
                'class' => 'form-control' // Clase estándar para el campo
            ]
        ) ?>

        <div class="ocupacion-especifica" style="display: none;">
            <?= $form->field($model, 'lugar_trabajo')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'horario_laboral')->textInput(['maxlength' => true]) ?>
        </div>
        </div>
        
        <!-- Segunda columna -->
        <div class="col-md-6">
        <?= $form->field($model, 'direccion_f1')->textInput(['maxlength' => true,'placeholder' => 'Cantón, Colonia, Barrio etc..']) ?>

        <?= $form->field($model, 'fk_distrito')->dropDownList(
        ArrayHelper::map(TblDistritos::find()->all(), 'id_distrito', 'nombre_distrito'),
        [
            'prompt' => 'Seleccione...',
            'class' => 'form-control tom-select-distrito', // Clase personalizada para Tom Select
            'id' => 'distritoId'        ]
        ) ?>
        <div class="municipio-departamento" style="display: none;">
            <?= $form->field($model, 'fk_municipio')->dropDownList(
                ArrayHelper::map(TblMunicipios::find()->all(), 'id_municipio', 'nombre_municipio'),
                [
                    'prompt' => 'Seleccione...',
                    'class' => 'form-control tom-select-municipio', // Clase personalizada para Tom Select
                    'id' => 'municipioId'
                ]
            ) ?>

            <?= $form->field($model, 'fk_departamento')->dropDownList(
                ArrayHelper::map(TblDepartamentos::find()->all(), 'id_departamento', 'nombre_departamento'),
                [
                    'prompt' => 'Seleccione...',
                    'class' => 'form-control tom-select-departamento', // Clase personalizada para Tom Select
                    'id' => 'departamentoId'
                ]
            ) ?>
        </div>
                </div>
                </div>

<?php if (!empty($dias) && !empty($turnos)) : ?>
<div id="tabla-dias-turnos" class="mt-5">
    <h3>Disponibilidad de horario</h3>
    <div class="checkbox-container"></div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>
                    <label>
                        <input type="checkbox" id="check-all-turnos">
                        <strong>All</strong>
                    </label>
                </th>
                <?php foreach ($dias as $dia) : ?>
                    <th>
                        <label>
                            <input type="checkbox" class="check-all-turnos" data-dia="<?= $dia->id_dia ?>" name="dias[]" value="<?= $dia->id_dia ?>">
                            <?= Html::encode($dia->nombre_dia) ?>
                        </label>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($turnos as $turno) : ?>
                <tr>
                    <td>
                        <label>
                            <input type="checkbox" class="turno-checkbox-all" value="<?= $turno->id_turno ?>">
                            <?= Html::encode($turno->nombre_turno) ?>
                        </label>
                    </td>
                    <?php foreach ($dias as $dia) : ?>
                        <td>
                            <label>
                                <input type="checkbox" name="turno-dia[<?= $dia->id_dia ?>][]" value="<?= $turno->id_turno ?>" class="turno-checkbox dia-<?= $dia->id_dia ?>" data-dia="<?= $dia->id_dia ?>">
                                <?= Html::encode($turno->nombre_turno) ?>
                            </label>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<script>
$(document).ready(function() {
$('#distritoId').on('change', function() {
    var distritoId = $(this).val();

    if (distritoId) {
        $.ajax({
            url: 'cargar', // URL a la acción cargar del controlador TblF1Controller
            type: 'post',
            data: {distritoId: distritoId},
            dataType: 'json',
            success: function(data) {
                console.log('Datos recibidos:', data); // Log para verificar la respuesta
                if (data.municipio_id !== null) {
                    var municipioSelect = document.querySelector('.tom-select-municipio');
                    municipioSelect.tomselect.setValue([data.municipio_id]);
                } else {
                    console.warn('No se encontró municipio para el distrito seleccionado');
                }
                if (data.departamento_id !== null) {
                    var departamentoSelect = document.querySelector('.tom-select-departamento');
                    departamentoSelect.tomselect.setValue([data.departamento_id]);
                } else {
                    console.warn('No se encontró departamento para el municipio seleccionado');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar datos:', xhr.responseText);
            }
        });
    }
});

$('#departamentoId').on('change', function() {
    var departamentoId = $(this).val();
    
    if (departamentoId) {
        $.ajax({
            url: 'cargar-municipios', // URL a la acción cargar-municipios del controlador TblF1Controller
            type: 'post',
            data: {departamentoId: departamentoId},
            dataType: 'json',
            success: function(data) {
                console.log('Municipios recibidos:', data);  },
            error: function(xhr, status, error) {
                console.error('Error al cargar municipios:', xhr.responseText);
            }
        });
    }
});

$('#municipioId').on('change', function() {
    var municipioId = $(this).val();

    if (municipioId) {
        $.ajax({
            url: 'cargar-distritos', // URL a la acción cargar-distritos del controlador TblF1Controller
            type: 'post',
            data: {municipioId: municipioId},
            dataType: 'json',
            success: function(data) {
                console.log('Distritos recibidos:', data); 
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar distritos:', xhr.responseText);
            }
        });
    }
});

    // Función para manejar la visibilidad de los campos basada en la ocupación seleccionada
    $('#ocupacionId').on('change', function() {
        var ocupacionId = $(this).val();
        var $camposOcupacionEspecifica = $('.ocupacion-especifica');

        // Ocultar todos los campos de ocupación específica por defecto
        $camposOcupacionEspecifica.hide();

        // Mostrar campos específicos si la ocupación seleccionada tiene el ID 2 (por ejemplo)
        if (ocupacionId == 2) { // Reemplaza 2 con el ID de la ocupación específica
            $camposOcupacionEspecifica.show();
        }
    });
    // Función para manejar la visibilidad de los campos basada en el distrito seleccionado
    $('#distritoId').on('change', function() {
        var distritoId = $(this).val();
        var $camposMunicipioDepartamento = $('.municipio-departamento');

        // Ocultar todos los campos de municipio y departamento por defecto
        $camposMunicipioDepartamento.hide();

        // Mostrar campos de municipio y departamento si se selecciona un distrito
        if (distritoId) {
            $camposMunicipioDepartamento.show();
        }
    });

        
        $('#check-all-turnos').on('change', function() {
        var isChecked = $(this).prop('checked');
        $('.turno-checkbox-all').prop('checked', isChecked);
        $('.check-all-turnos').prop('checked', isChecked);
        $('.turno-checkbox').prop('checked', isChecked);

        // Seleccionar o deseleccionar todos los días
        if (isChecked) {
            $('.check-all-turnos').each(function() {
                var diaId = $(this).data('dia');
                $('.dia-' + diaId).prop('checked', true);
            });
        } else {
            $('.check-all-turnos').prop('checked', false);
        }
    });

    // Seleccionar o deseleccionar todos los turnos de un día específico
    $('.check-all-turnos').on('change', function() {
        var diaId = $(this).data('dia');
        var isChecked = $(this).prop('checked');
        $('.dia-' + diaId).prop('checked', isChecked);

        // Marcar el día correspondiente si se selecciona un turno
        if (isChecked) {
            $('.check-all-turnos[data-dia="' + diaId + '"]').prop('checked', true);
        } else {
            // Verificar si algún otro turno del mismo día está seleccionado
            var anyOtherTurnoChecked = $('.turno-checkbox[data-dia="' + diaId + '"]:checked').length > 0;
            if (!anyOtherTurnoChecked) {
                $('.check-all-turnos[data-dia="' + diaId + '"]').prop('checked', false);
            }
        }
    });

    // Seleccionar o deseleccionar todos los turnos para todos los días
    $('.turno-checkbox-all').on('change', function() {
        var turnoId = $(this).val();
        var isChecked = $(this).prop('checked');

        if (isChecked) {
            $('.turno-checkbox[value="' + turnoId + '"]').prop('checked', true);
            $('.turno-checkbox[value="' + turnoId + '"]').each(function() {
                var diaId = $(this).data('dia');
                $('.check-all-turnos[data-dia="' + diaId + '"]').prop('checked', true);
            });
        } else {
            $('.turno-checkbox[value="' + turnoId + '"]').prop('checked', false);
            $('.turno-checkbox[value="' + turnoId + '"]').each(function() {
                var diaId = $(this).data('dia');
                $('.check-all-turnos[data-dia="' + diaId + '"]').prop('checked', false);
            });
        }
    });

    // Manejo del checkbox de un turno específico para marcar también el día correspondiente
    $('.turno-checkbox').on('change', function() {
        var diaId = $(this).data('dia');
        var isChecked = $(this).prop('checked');

        if (isChecked) {
            $('.check-all-turnos[data-dia="' + diaId + '"]').prop('checked', true);
        } else {
            var anyOtherTurnoChecked = $('.turno-checkbox[data-dia="' + diaId + '"]:checked').length > 0;
            if (!anyOtherTurnoChecked) {
                $('.check-all-turnos[data-dia="' + diaId + '"]').prop('checked', false);
            }
        }
    });
    

});
</script>
<?php
$this->registerJs("
    new TomSelect('.tom-select-carrera', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });
    new TomSelect('.tom-select-distrito', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });
        new TomSelect('.tom-select-municipio', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });
        new TomSelect('.tom-select-departamento', {
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