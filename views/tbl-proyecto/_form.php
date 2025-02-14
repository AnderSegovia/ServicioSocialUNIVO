<?php

use app\models\TblCarrera;
use app\models\TblEstadoProyecto;
use app\models\TblImpacto;
use app\models\TblInstituciones;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\TblProyecto $model */
/** @var yii\widgets\ActiveForm $form */

// Obtener todas las carreras e instituciones como arrays asociativos
$carreraOptions = ArrayHelper::map(TblCarrera::find()->all(), 'id_carrera', 'nombre_carrera');
$institucionOptions = ArrayHelper::map(TblInstituciones::find()->all(), 'id_institucion', 'nombre_institucion');

// Registrar el script JavaScript para la funcionalidad dinámica en las listas
$this->registerJs("
    $(document).ready(function() {
        // Configuración para cada campo de lista desplegable
        var dropdownConfigs = [
            { field: $('#tblproyecto-fk_carrera_proyecto'), options: " . json_encode($carreraOptions) . " },
            { field: $('#tblproyecto-fk_institucion'), options: " . json_encode($institucionOptions) . " }
        ];

        // Variable para mantener el estado del botón de agregar institución
        var addButtonAdded = false;

        $.each(dropdownConfigs, function(index, config) {
            var dropdown = config.field;
            var options = config.options;
            var filterInput = $('<input type=\"text\" class=\"form-control\" placeholder=\"Filtrar...\">');

            // Agregar campo de filtro antes de la lista desplegable
            dropdown.before(filterInput);

            // Función para filtrar y mostrar opciones según el valor del filtro
            filterInput.on('input', function() {
                var filterValue = $(this).val().toUpperCase();
                var dropdownOptions = [];

                $.each(options, function(key, value) {
                    if (value.toUpperCase().indexOf(filterValue) !== -1) {
                        dropdownOptions.push('<option value=\"' + key + '\">' + value + '</option>');
                    }
                });

                // Mostrar todas las opciones que coincidan con el filtro
                dropdown.html(dropdownOptions.join(''));
                dropdown.toggle(dropdownOptions.length > 0); // Mostrar la lista si hay coincidencias, ocultarla si no

                // Si el filtro está vacío, mostrar todas las opciones
                if (filterValue === '') {
                    dropdown.html('');
                    addButtonAdded = false; // Reiniciar el estado del botón al vaciar el filtro
                    $('#btn-agregar-institucion').remove(); // Quitar el botón si el filtro está vacío
                } else {
                    // Mostrar botón para agregar institución si no hay coincidencias y no se ha agregado el botón aún
                    if (dropdownOptions.length === 0 && !addButtonAdded) {
                        dropdown.after('<button type=\"button\" class=\"btn btn-primary\" id=\"btn-agregar-institucion\">Agregar Institución</button>');
                        addButtonAdded = true; // Marcar que se ha agregado el botón
                    } else if (dropdownOptions.length > 0) {
                        $('#btn-agregar-institucion').remove(); // Quitar el botón si hay coincidencias
                        addButtonAdded = false; // Reiniciar el estado del botón si hay coincidencias
                    }
                }
            });

            // Seleccionar opción al hacer clic en la lista desplegable
            dropdown.on('change', function() {
                filterInput.val($(this).find('option:selected').text());
                dropdown.hide();
            });
        });

        // Manejar click en el botón para agregar institución
        $(document).on('click', '#btn-agregar-institucion', function() {
            var nuevaInstitucion = prompt('Ingrese el nombre de la nueva institución:');
            if (nuevaInstitucion) {
                // Realizar una petición AJAX para guardar la nueva institución
                $.ajax({
                    url: '" . Url::to(['tbl-instituciones/save-institucion']) . "',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        nombre_institucion: nuevaInstitucion
                    },
                    success: function(response) {
                        alert('Nueva institución agregada con éxito: ' + response.nombre_institucion);
                         location.reload();
                        },
                    error: function(xhr, status, error) {
                        alert('Error al agregar la institución: ' + error);
                    }
                });
            } else {
                alert('No se ingresó ningún nombre de institución.');
            }
        });
    });
");
?>

<div class="tbl-proyecto-form">
    <?php $form = ActiveForm::begin(); ?>

    <!-- Contenedor principal con Bootstrap grid system -->
    <div class="row">
        <!-- Primera columna -->
        <div class="col-md-6">
            <?= $form->field($model, 'fk_institucion')->dropDownList($institucionOptions, ['prompt' => 'Seleccione...']) ?>
            <?= $form->field($model, 'fk_carrera_proyecto')->dropDownList($carreraOptions, ['prompt' => 'Seleccione...']) ?>
            <?= $form->field($model, 'nombre_proyecto')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'numero_registro')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'horario')->textInput(['maxlength' => true]) ?>
        </div>
        
        <!-- Segunda columna -->
        <div class="col-md-6">
<?= $form->field($model, 'fecha_inicio')->textInput(['maxlength' => true, 'id' => 'fecha_inicio']) ?>
<?= $form->field($model, 'fecha_fin')->textInput(['maxlength' => true, 'id' => 'fecha_fin']) ?>

<?= $form->field($model, 'cant_beneficiados')->textInput(['type' => 'number', 'min' => 0]) ?>
<?= $form->field($model, 'cant_inversion')->textInput(['type' => 'number', 'min' => 0, 'step' => '0.01']) ?>

            <?= $form->field($model, 'fk_impacto')->dropDownList(
                ArrayHelper::map(TblImpacto::find()->all(), 'id_impacto', 'nombre_impacto'),
                ['prompt' => 'Seleccione...']
            ) ?>
            <?= $form->field($model, 'fk_estado_proyecto')->dropDownList(
                ArrayHelper::map(TblEstadoProyecto::find()->all(), 'id_estado_proyecto', 'estado_proyecto'),
                ['prompt' => 'Seleccione...']
            ) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script>
function formatDateInput(input) {
    let value = input.value.replace(/\D/g, ''); // Eliminar cualquier carácter que no sea número
    if (value.length >= 4) {
        value = value.slice(0, 4) + '-' + value.slice(4); // Añadir el primer guión después de los primeros 4 dígitos
    }
    if (value.length >= 7) {
        value = value.slice(0, 7) + '-' + value.slice(7); // Añadir el segundo guión después de los 2 dígitos siguientes
    }
    input.value = value.slice(0, 10); // Limitar el valor a 10 caracteres
}

document.getElementById('fecha_inicio').addEventListener('input', function() {
    formatDateInput(this);
});

document.getElementById('fecha_fin').addEventListener('input', function() {
    formatDateInput(this);
});
</script>


