<?php

use app\assets\AppAsset;
use app\models\TblCarrera;
use app\models\TblEstadoAlumno;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TblAlumno $model */
/** @var yii\widgets\ActiveForm $form */
AppAsset::register($this);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css', ['depends' => [\yii\web\YiiAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="tbl-alumno-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <!-- Primera columna -->
        <div class="col-md-6">

<?= $form->field($model, 'nombre_alumno')->textInput([
    'maxlength' => true,
    'id' => 'nombre-alumno-input'
]) ?>

<?= $form->field($model, 'codigo')->textInput([
    'maxlength' => true,
    'id' => 'codigo-input', // ID único
    'placeholder' => ''
]) ?>

<?= $form->field($model, 'telefono')->textInput([
    'maxlength' => true,
    'id' => 'telefono-input',
    'placeholder' => '',
]) ?>


<?= $form->field($model, 'correo')->textInput([
    'maxlength' => true,
    'id' => 'correo-input', // ID único
    'placeholder' => '' // Ayuda visual
]) ?>
    </div>
        
        <!-- Segunda columna -->
        <div class="col-md-6">

        <?= $form->field($model, 'fk_carrera')->dropDownList(
    ArrayHelper::map(TblCarrera::find()->all(), 'id_carrera', 'nombre_carrera'),
    [
        'prompt' => 'Seleccione...',
        'class' => 'form-control tom-select-carrera' // Clase personalizada para Tom Select
    ]
) ?>

        <?= $form->field($model, 'numero_materias')->input('number', ['min' => 10, 'max' => 50])->label('Cantidad de Materias Aprobadas') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs(<<<JS
    document.getElementById('codigo-input').addEventListener('input', function() {
        let value = this.value.toUpperCase(); // Convertir a mayúsculas automáticamente
        let regex = /^[UM][0-9]*$/; // U o M seguido de números
        
        // Validar mientras escribe
        if (!regex.test(value)) {
            value = value.replace(/[^UM0-9]/gi, ''); // Eliminar caracteres no permitidos
            if (value.length > 0 && !value.startsWith('U') && !value.startsWith('M')) {
                value = value.substring(1); // Eliminar el primer carácter inválido
            }
        }
        this.value = value;
    });
JS);


$this->registerJs(<<<JS
    document.getElementById('telefono-input').addEventListener('input', function() {
        // Permitir solo números eliminando cualquier caracter no numérico
        let value = this.value.replace(/[^0-9]/g, '');

        // Insertar el guion después de los primeros 4 dígitos
        if (value.length > 4) {
            value = value.substring(0, 4) + '-' + value.substring(4);
        }
        
        // Actualizar el valor del campo
        this.value = value;
    });
JS);
$this->registerJs(<<<JS
    document.getElementById('correo-input').addEventListener('input', function() {
        const value = this.value;
        const regex = /^[^@]+@[^@]+\\.[a-zA-Z]{2,}$/; // Formato básico de correo electrónico
        
        // Validar formato general del correo
        if (!regex.test(value) && value.length > 0) {
            this.setCustomValidity('Ingrese un correo válido con un @ y dominio.');
        } else {
            this.setCustomValidity('');
        }
    });
JS);


$this->registerJs(<<<JS
    document.getElementById('nombre-alumno-input').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
JS);

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
");
?>
