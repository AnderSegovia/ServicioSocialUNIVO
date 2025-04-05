<?php

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblAlumno;
use yii\web\UploadedFile;


AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->title = 'Seleccionar Estudiantes';

// Obtener la lista de alumnos con sus carreras
$alumnos = TblAlumno::find()->joinWith('fkCarrera')->all();

$form = ActiveForm::begin([
    'id' => 'form-seleccion-estudiantes',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
]);
?>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="row">
    <div class="col-md-6">
        <!-- Selector de estudiantes -->
        <?= $form->field($model, 'id_alumno')->dropDownList(
            ArrayHelper::map($alumnos, 'id_alumno', function ($model) {
                return $model->codigo . ' - ' . $model->nombre_alumno;
            }),
            [
                'prompt' => 'Seleccione...',
                'class' => 'form-control tom-select-carrera',
                'options' => ArrayHelper::map($alumnos, 'id_alumno', function ($model) {
                    return ['data-fk-carrera' => $model->fk_carrera, 'data-carrera-nombre' => $model->fkCarrera->nombre_carrera];
                }),
            ]
        ) ?>
    </div>
    <div class="col-md-6">
        <!-- Selector de instituciones -->
        <label>Institución</label>
        <?= Html::dropDownList('id_institucion', null,
            ArrayHelper::map($instituciones, 'id_institucion', 'nombre_institucion'),
            [
                'prompt' => 'Seleccione una institución...',
                'class' => 'form-control tom-select-institucion',
                'required' => true,
            ]
        ) ?>
        <?= $form->field($model, 'campoNumerico')->input('number', ['min' => 200, 'max' => 500, 'id' => 'campo-numerico'])->label('Cantidad de horas') ?>
    </div>

</div>

<!-- Tabla dinámica para mostrar los estudiantes seleccionados -->
<table class="table table-bordered" id="tabla-estudiantes">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Carrera</th>
            <th>Gender</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- Botones para enviar los datos de la tabla -->
<div class="form-group">
    <div class="row">
        <div class="col-md-2">
            <?= Html::submitButton('Generar Carta', ['class' => 'btn btn-primary', 'id' => 'btn-generar-carta', 'disabled' => true]) ?>
            </div>
            <div class="col-md-4">
                <!-- Subir Plan -->
                <?= Html::button('Subir Plan', ['class' => 'btn btn-primary', 'id' => 'btn-upload-plan', 'disabled' => true]) ?>
                <?= $form->field($model, 'pdfFile1')->fileInput(['id' => 'pdf-file-1', 'disabled' => true])->label(false) ?>
            </div>
            <div class="col-md-4">
                <!-- Subir Memoria -->
                <?= Html::button('Subir Memoria', ['class' => 'btn btn-primary', 'id' => 'btn-upload-memoria', 'disabled' => true]) ?>
                <?= $form->field($model, 'pdfFile2')->fileInput(['id' => 'pdf-file-2', 'disabled' => true])->label(false) ?>
            </div>
            <div class="col-md-2">
            <?= Html::button('Constancia', ['class' => 'btn btn-primary', 'id' => 'btn-abrir-modal', 'disabled' => true]) ?>

        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>

<div class="modal fade" id="modalDatosAdicionales" tabindex="-1" role="dialog" aria-labelledby="modalDatosAdicionalesLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDatosAdicionalesLabel">Datos Adicionales</h5>
            </div>
            
            <div class="modal-body">
                <form id="form-datos-adicionales">
                <input type="number" style="display: none;" id="proyectoId" name="proyectoId">

                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select class="form-control" id="tipo" name="tipo">
                    <option value="1">Normal</option>
                        <option value="2">Dos proyectos</option>
                        <option value="3">Segunda carrera</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombreProyecto">Nombre del Proyecto</label>
                    <textarea class="form-control" id="nombreProyecto" name="nombreProyecto" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="from_date">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date">
                </div>

                <div class="form-group">
                    <label for="to_date">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date">
                </div>
                <div id="actividades" style="display: none;">
                    <label for="jv">Actividades de Junta de Vigilancia.</label>
                    <div id="input-container">
                        <div class="input-group" style="display: flex; gap: 10px;">
                            <input type="text" class="form-control" id="junta" name="junta[]" style="flex: 1;">
                            <input type="number" class="form-control" id="horas" name="horas[]" style="flex: 1;">
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-agregar">Agregar</button>
                </div>
                <div id="additionalFields" style="display: none;">
                <div class="form-group">
                        <label for="campo2">Nombre del Segundo Proyecto</label>
                        <textarea class="form-control" id="campo2" name="campo2" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Institución</label>
                        <?= Html::dropDownList('id_institucion', null,
                            ArrayHelper::map($instituciones, 'id_institucion', 'nombre_institucion'),
                            [
                                'prompt' => 'Seleccione una institución...',
                                'class' => 'form-control tom-select-institucions',
                                'required' => true,
                            ]
                        ) ?>
                    <div class="form-group">
                        <label for="from_date2">From Date</label>
                        <input type="date" class="form-control" id="from_date2" name="from_date2">
                    </div>

                    <div class="form-group">
                        <label for="to_date2">To Date</label>
                        <input type="date" class="form-control" id="to_date2" name="to_date2">
                    </div>


                    <div id="actividades2" style="display: none;">
                        <label for="jv2">Actividades de Junta de Vigilancia.</label>
                        <div id="input-container2">
                            <div class="input-group" style="display: flex; gap: 10px;">
                                <input type="text" class="form-control" id="junta2" name="junta2[]" style="flex: 1;">
                                <input type="number" class="form-control" id="horas2" name="horas2[]" style="flex: 1;">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn-agregar2">Agregar</button>
                    </div>


                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-enviar-modal">Enviar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 document.getElementById('btn-agregar').addEventListener('click', function() {
    var inputGroup = document.createElement('div');
    inputGroup.className = 'input-group';
    inputGroup.style.display = 'flex';
    inputGroup.style.gap = '10px';

    var newTextInput = document.createElement('input');
    newTextInput.type = 'text';
    newTextInput.className = 'form-control';
    newTextInput.name = 'junta[]';
    newTextInput.style.flex = '1';

    var newNumberInput = document.createElement('input');
    newNumberInput.type = 'number';
    newNumberInput.className = 'form-control';
    newNumberInput.name = 'horas[]';
    newNumberInput.style.flex = '1';

    inputGroup.appendChild(newTextInput);
    inputGroup.appendChild(newNumberInput);

    document.getElementById('input-container').appendChild(inputGroup);
 });
    document.getElementById('btn-agregar2').addEventListener('click', function() {
        var inputGroup = document.createElement('div');
        inputGroup.className = 'input-group';
        inputGroup.style.display = 'flex';
        inputGroup.style.gap = '10px';

        var newTextInput = document.createElement('input');
        newTextInput.type = 'text';
        newTextInput.className = 'form-control';
        newTextInput.name = 'junta2[]';
        newTextInput.style.flex = '1';

        var newNumberInput = document.createElement('input');
        newNumberInput.type = 'number';
        newNumberInput.className = 'form-control';
        newNumberInput.name = 'horas2[]';
        newNumberInput.style.flex = '1';

        inputGroup.appendChild(newTextInput);
        inputGroup.appendChild(newNumberInput);

        document.getElementById('input-container2').appendChild(inputGroup);
    });
 $(document).ready(function() {
    $('#btn-abrir-modal').on('click', function() {
        $('#modalDatosAdicionales').modal('show');
    });

    $('#btn-enviar-modal').on('click', function() {
        let formDatosAdicionales = $('#form-datos-adicionales').serializeArray();
        let datosAdicionales = {};
        formDatosAdicionales.forEach(function(field) {
            datosAdicionales[field.name] = field.value;
        });
        
        let actividades = [];
    
    document.querySelectorAll('#input-container .input-group').forEach(function(group) {
        let junta = group.querySelector('input[name="junta[]"]').value;
        let horas = group.querySelector('input[name="horas[]"]').value;
        actividades.push({ junta: junta, horas: horas });
    });

    console.log('Actividades:', actividades);

    let actividades2 = [];
    
    document.querySelectorAll('#input-container2 .input-group').forEach(function(group) {
        let junta2 = group.querySelector('input[name="junta2[]"]').value;
        let horas2 = group.querySelector('input[name="horas2[]"]').value;
        actividades2.push({ junta2: junta2, horas2: horas2 });
    });

        let estudiantes = [];
        $('#tabla-estudiantes tbody tr').each(function() {
            let id = $(this).data('id');
            let gender = $(this).find('select[name="gender"]').val();
            let titulo = $(this).find('select[name="titulo"]').val();

            estudiantes.push({ id: id, gender: gender, titulo: titulo});
        });

        let institucionSeleccionada = $('.tom-select-institucion').val();
        let institucionSeleccionada2 = $('.tom-select-institucions').val();
        if (!institucionSeleccionada2) {
            institucionSeleccionada2 = 1;
        }

        let datos = {
            datosAdicionales: datosAdicionales,
            actividades: actividades,
            actividades2: actividades2,
            estudiantes: estudiantes,
            idInstitucion: institucionSeleccionada,
            idInstitucion2: institucionSeleccionada2
        };

        $.ajax({
            url: 'constancia', 
            type: 'POST',
            data: datos,
            success: function(response) {
                if (response.success) {
                    console.log(response);
                    window.open(response.combinedPdfUrl, '_blank');
                    $('#modalDatosAdicionales').modal('hide');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error al enviar los datos: ' + xhr.responseText);
            }
        });
    });
 });

    $(document).ready(function() {
        $('#tipo').change(function() {
            if ($(this).val() == '2') {
                $('#additionalFields').show();
            } else {
                $('#additionalFields').hide();
            }
        });
    });


</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let estudiantesSeleccionados = {};
        let carreraSeleccionada = null;

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

        var tomSelectInstance = new TomSelect('.tom-select-institucion', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });
    var tomSelectInstance2 = new TomSelect('.tom-select-institucions', {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc'
        },
        searchField: ['text'],
        plugins: ['remove_button'],
        dropdownParent: 'body',
    });

    function toggleButtons() {
        let valorCampoNumerico = $('#campo-numerico').val();
        let institucionSeleccionada = $('.tom-select-institucion').val();

        let allStudentsSelected = true;
        let studentCount = 0;

        $('#tabla-estudiantes tbody tr').each(function() {
            let genderSelected = $(this).find('select[name="gender"]').val();
            if (!genderSelected) {
                allStudentsSelected = false;
            }
            studentCount++;
        });

        let hasStudents = studentCount > 0;

        if (institucionSeleccionada && allStudentsSelected && hasStudents) {
            $('#btn-abrir-modal').prop('disabled', false).css('cursor', 'pointer' ).addClass('btn btn-success');
        } else {
            $('#btn-abrir-modal').prop('disabled', true).css('cursor', 'not-allowed');
        }
        if (institucionSeleccionada && hasStudents) {
            $('#pdf-file-1, #pdf-file-2').prop('disabled', false).css('cursor', 'pointer');
            $('#btn-upload-plan, #btn-upload-memoria').prop('disabled', false).css('cursor', 'pointer').addClass('btn btn-success');
        } else {
            $('#btn-upload-plan, #btn-upload-memoria, #pdf-file-1, #pdf-file-2').prop('disabled', true).css('cursor', 'not-allowed');
        }

        if (valorCampoNumerico && institucionSeleccionada && hasStudents) {
            $('#btn-generar-carta').prop('disabled', false).css('cursor', 'pointer').addClass('btn btn-success');
        } else {
            $('#btn-generar-carta').prop('disabled', true).css('cursor', 'not-allowed');
        }

    }
            $('#campo-numerico').on('input', toggleButtons);
            $('.tom-select-institucion').on('change', toggleButtons);
            $('#tabla-estudiantes').on('change', 'select[name="gender"]', toggleButtons);

            $(document).ready(function() {
                toggleButtons();
            });

            document.getElementById('btn-generar-carta').addEventListener('click', function(event) {
            event.preventDefault();

            let selectedIds = Object.keys(estudiantesSeleccionados);
            let idAlumnosValue = selectedIds.join(',');
            let idInstitucion = document.querySelector('.tom-select-institucion').value;

            if (selectedIds.length === 0) {
                alert('Debe seleccionar al menos un estudiante.');
                return;
            }

            fetch('<?= Yii::$app->urlManager->createUrl(['carta/verificar-estados']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>'
                },
                body: JSON.stringify({ ids: selectedIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.estadosInvalidos && data.estadosInvalidos.length > 0) {
                    const nombres = data.estadosInvalidos.map(e => `${e.nombre} (${e.estado})`).join('\n');
                    const continuar = confirm(`Los siguientes estudiantes no tienen estado Sin Asignar:\n\n${nombres}\n\n¿Desea continuar de todos modos?`);
                    if (!continuar) return;
                }

                const formData = new FormData();
                formData.append('idAlumnos', idAlumnosValue);
                formData.append('idInstitucion', idInstitucion);

                enviarDatos('<?= Yii::$app->urlManager->createUrl(['carta/generar-carta']) ?>', formData);
            })
            .catch(error => {
                console.error('Error al verificar estados:', error);
                alert('Ocurrió un error al verificar los estados.');
            });
        });

    function enviarDatos(url) {
        let selectedIds = Object.keys(estudiantesSeleccionados);
        let idInstitucion = document.querySelector('.tom-select-institucion').value;
        let campoNumerico = document.getElementById('campo-numerico').value;

        if (selectedIds.length > 0) {
            let idAlumnosValue = selectedIds.join(',');

            url += '?idAlumnos=' + encodeURIComponent(idAlumnosValue);
            url += '&idInstitucion=' + encodeURIComponent(idInstitucion);
            url += '&campoNumerico=' + encodeURIComponent(campoNumerico);

            window.location.href = url;
        } else {
            alert('Debe agregar al menos un estudiante para continuar.');
        }
    }
        document.getElementById('btn-upload-plan').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('pdf-file-1').click();
        });

        document.getElementById('btn-upload-memoria').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('pdf-file-2').click();
        });

        document.getElementById('pdf-file-1').addEventListener('change', function() {
            var file = this.files[0];
            subirArchivo(file, 2); 
        });

        document.getElementById('pdf-file-2').addEventListener('change', function() {
            var file = this.files[0];
            subirArchivo(file, 3); 
        });

    function subirArchivo(file, tipo) {
        var formData = new FormData();
        formData.append('_csrf', '<?= Yii::$app->request->csrfToken ?>');
        formData.append('pdfFile', file);
        formData.append('tipo', tipo); 

       
        let selectedIds = Object.keys(estudiantesSeleccionados);
        let idAlumnosValue = selectedIds.join(',');

        let idInstitucion = document.querySelector('.tom-select-institucion').value;
            formData.append('idAlumnos', idAlumnosValue);
            formData.append('idInstitucion', idInstitucion);
            console.log(idAlumnosValue)

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= Yii::$app->urlManager->createUrl(['carta/subir']) ?>', true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            mostrarAlerta();
                        } else {
                            mostrarAlerta();
                        }
                } else {
                    alert('Error al subir el archivo.');
                }
            }
        };

        xhr.send(formData);
    }
    function filtrarListaEstudiantes(carrera) {
        let select = document.getElementById('tblalumno-id_alumno');
        let options = select.options;

        for (let i = 0; i < options.length; i++) {
            let option = options[i];
            if (option.value) {
                let fkCarrera = option.getAttribute('data-fk-carrera');
                if (fkCarrera !== carrera) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                }
            }
        }
    }

    function restablecerListaEstudiantes() {
        let select = document.getElementById('tblalumno-id_alumno');
        let options = select.options;

        for (let i = 0; i < options.length; i++) {
            options[i].style.display = 'block';
        }
    }

    document.querySelector('#tabla-estudiantes').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn-quitar')) {
            let row = event.target.closest('tr');
            let id = row.getAttribute('data-id');
            delete estudiantesSeleccionados[id];
            row.remove();
            if (Object.keys(estudiantesSeleccionados).length === 0) {
                carreraSeleccionada = null;
                restablecerListaEstudiantes();
            }
        }
    });

    document.getElementById('tblalumno-id_alumno').addEventListener('change', function() {
    let select = this;
    let id = select.value;
    let texto = select.options[select.selectedIndex].text;
    let nombreCarrera = select.options[select.selectedIndex].getAttribute('data-carrera-nombre');

    if (id && !estudiantesSeleccionados[id]) {
        estudiantesSeleccionados[id] = texto;

        console.log('IDs seleccionados:', Object.keys(estudiantesSeleccionados));

        let tbody = document.querySelector('#tabla-estudiantes tbody');
        let row = document.createElement('tr');
        row.setAttribute('data-id', id);
        row.innerHTML = `
            <td>${texto.split(' - ')[0]}</td>
            <td>${texto.split(' - ')[1]}</td>
            <td>${nombreCarrera}</td>
            <td>
                <select class="form-control" id="gender" name="gender">
                    <option value="">Select gender</option>
                    <option value="1">Female</option>
                    <option value="2">Male</option>
                </select>
            </td>
            <td>
                <select class="form-control" id="titulo" name="titulo">
                    <option value="Bachiller">Bachiller</option>
                    <option value="Licenciada">Licenciada</option>
                    <option value="Licenciado">Licenciado</option>
                    <option value="Ingeniera">Ingeniera</option>
                    <option value="Ingeniero">Ingeniero</option>
                    <option value="Profesor">Profesor</option>
                    <option value="Profesora">Profesora</option>
                    <option value="Arquitecta">Arquitecta</option>
                    <option value="Arquitecto">Arquitecto</option>
                    <option value="Técnico">Técnico</option>
                </select>
            </td>
            <td><button class='btn btn-danger btn-quitar'>Quitar</button></td>
        `;
        tbody.appendChild(row);

        select.value = '';
        select.tomselect.clear();

        row.querySelector('.btn-quitar').addEventListener('click', function() {
            delete estudiantesSeleccionados[id];
            row.remove();
            if (Object.keys(estudiantesSeleccionados).length === 0) {
                carreraSeleccionada = null;
                restablecerListaEstudiantes();
            }
            toggleButtons();
        });

        $.ajax({
            url: 'project-name',
            type: 'GET',
            data: { idAlumno: id },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    console.log('Nombre del Proyecto: ' + data.nombre_proyecto + data.institucion_id);
                    if(data.carreraPs == 33 || data.carreraPs == 56){
                        $('#actividades').show();
                        $('#actividades2').show();
                    } else {
                        $('#actividades').hide();
                        $('#actividades2').hide();
                    }
                    
                    $('#nombreProyecto').val(data.nombre_proyecto);
                    tomSelectInstance.setValue(data.institucion_id);
                    $('#proyectoId').val(data.proyectoId);

                    
                    if (data.nombre_proyecto_secundario) {
                        $('#campo2').val(data.nombre_proyecto_secundario);
                        tomSelectInstance2.setValue(data.institucion_id_secundaria);
                    } else {
                        $('#campo2').val('');
                        $('#institucion2').val('');
                    }
                    data.otros_alumnos.forEach(function(alumnoId) {                       
                console.log('IDs seleccionados:', alumnoId);
                        let option = select.querySelector(`option[value="${alumnoId}"]`);
                        if (option) {
                            let estudianteTexto = option.text;
                            estudiantesSeleccionados[alumnoId] = estudianteTexto;
                            console.log('Estudiante adicional agregado:', alumnoId, estudianteTexto);
                            let estudianteCarrera = option.getAttribute('data-carrera-nombre');
                            let estudianteRow = document.createElement('tr');
                            estudianteRow.setAttribute('data-id', alumnoId);
                            estudianteRow.innerHTML = `
                                <td>${estudianteTexto.split(' - ')[0]}</td>
                                <td>${estudianteTexto.split(' - ')[1]}</td>
                                <td>${estudianteCarrera}</td>
                                <td>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="">Select gender</option>
                                        <option value="1">Female</option>
                                        <option value="2">Male</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="titulo" name="titulo">
                                        <option value="Bachiller">Bachiller</option>
                                        <option value="Licenciada">Licenciada</option>
                                        <option value="Licenciado">Licenciado</option>
                                        <option value="Ingeniera">Ingeniera</option>
                                        <option value="Ingeniero">Ingeniero</option>
                                        <option value="Profesor">Profesor</option>
                                        <option value="Profesora">Profesora</option>
                                        <option value="Arquitecta">Arquitecta</option>
                                        <option value="Arquitecto">Arquitecto</option>
                                        <option value="Técnico">Técnico</option>
                                    </select>
                                </td>
                                <td><button class='btn btn-danger btn-quitar'>Quitar</button></td>
                            `;
                            tbody.appendChild(estudianteRow);
                            estudianteRow.querySelector('.btn-quitar').addEventListener('click', function() {
                                delete estudiantesSeleccionados[alumnoId];
                                estudianteRow.remove();
                                if (Object.keys(estudiantesSeleccionados).length === 0) {
                                    carreraSeleccionada = null;
                                    restablecerListaEstudiantes();
                                }
                                toggleButtons();
                            });
                        }
                    });
                    console.log('Estado final del diccionario de estudiantes:', estudiantesSeleccionados);

                } else {
                    console.log('No se encontró el proyecto.');
                }
            },
            error: function() {
                console.log('Error al obtener el nombre del proyecto.');
            }
        });
        toggleButtons();
    }
    });
        document.getElementById('form-seleccion-estudiantes').addEventListener('submit', function(event) {
            if (Object.keys(estudiantesSeleccionados).length === 0) {
                alert('Debe agregar al menos un estudiante para continuar.');
                event.preventDefault();
            }
        });
    });
</script>

<script>
    function mostrarAlerta() {
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your work has been saved",
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        location.reload();
    });
    
    }   
    function alertaError() {
        Swal.fire({
    icon: "error",
    title: "Oops...",
    text: "Something went wrong!",
    footer: '<p>Try again later</p>'
    });
        
    } 
</script>