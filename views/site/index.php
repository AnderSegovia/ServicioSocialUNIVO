<?php
use yii\helpers\Html;

$this->title = 'Servicio Social UNIVO';
?>

<style>
    /* Estilos adicionales para centrar verticalmente las cards */
    .container-fluid {
        display: flex;
        justify-content: space-around; /* Distribución uniforme de las cards */
        align-items: center;
        height: 70vh; /* Altura del viewport */
    }

    /* Estilos personalizados para las cards */
    .card-custom {
        width: 100%;
        max-width: 450px; /* Ancho máximo ajustado para las cards */
    }

    .card {
        transition: transform 0.3s ease;
        margin-bottom: 20px; /* Espacio inferior entre las cards */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); /* Sombras más evidentes en hover */
    }
</style>

<div class="site-index">
    <div class="container-fluid">
        <div class="row justify-content-around">
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm card-custom">
                    <div class="card-body">
                        <h5 class="card-title text-center">Names</h5>
                        <p class="card-text">CRUD de la db con nombres y apellidos con tildes a considerar al momento de hacer constancias.</p>
                        <?= Html::a('Go', ['tbl-names/index'], ['class' => 'btn btn-primary stretched-link']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm card-custom">
                    <div class="card-body">
                        <h5 class="card-title text-center">Alertas</h5>
                        <p class="card-text">Seguimiento a estudiantes asignados, sin plan de trabajo en sistema.</p>
                        <?= Html::a('Go', ['expediente/index'], ['class' => 'btn btn-primary stretched-link']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm card-custom">
                    <div class="card-body">
                        <h5 class="card-title text-center">Facultades</h5>
                        <p class="card-text">Ver la lista de Facultades de la Universidad.</p>
                        <?= Html::a('Go', ['tbl-facultad/index'], ['class' => 'btn btn-primary stretched-link']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm card-custom">
                    <div class="card-body">
                        <h5 class="card-title text-center">Carrreas</h5>
                        <p class="card-text">Ver la lista completa de carreras de la Universidad.</p>
                            <?= Html::a('Go', ['tbl-carrera/index'], ['class' => 'btn btn-primary stretched-link']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm card-custom">
                    <div class="card-body">
                        <h5 class="card-title text-center">Cargos</h5>
                        <p class="card-text">CRUD de los datos de las personas de encargadas firmar las constancias de SS.</p>
                        <?= Html::a('Go', ['tbl-cargos/index'], ['class' => 'btn btn-primary stretched-link']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm card-custom">
                    <div class="card-body">
                        <h5 class="card-title text-center">Lineas de Accion</h5>
                        <p class="card-text">Lista de las actvidades de las lineas de accion con las que se trabaja.</p>
                        <?= Html::a('Go', ['tbl-actividad/index'], ['class' => 'btn btn-primary stretched-link']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Enlaces a los archivos JavaScript de Bootstrap (opcional si no están ya incluidos en tu layout principal)
$this->registerCssFile('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
$this->registerJsFile('https://code.jquery.com/jquery-3.5.1.slim.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
