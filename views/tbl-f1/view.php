<?php

use app\models\TblDias;
use app\models\TblTurnos;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TblF1 $model */

$this->title = $model->id_f1;
$this->params['breadcrumbs'][] = ['label' => 'Tbl F1s', 'url' => ['index']];
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



<div class="tbl-f1-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id_f1' => $model->id_f1], [
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
            'id_f1',
            [
                'attribute' => 'fk_alumnof1',
                'value' => function ($model) {
                    return $model->fkAlumnof1 ? $model->fkAlumnof1->nombre_alumno : 'Sin asignar';
                },
            ],
            [
                'attribute' => 'fk_alumnof1',
                'label' => 'Codigo',
                'value' => function ($model) {
                    return $model->fkAlumnof1 ? $model->fkAlumnof1->codigo : 'Sin asignar';
                },
            ],
            [
                'attribute' => 'fk_alumnof1',
                'label' => 'Carrera',
                'value' => function ($model) {
                    return $model->fkAlumnof1 ? $model->fkAlumnof1->fkCarrera->nombre_carrera : 'Sin asignar';
                },
            ],
            'fecha_f1',
            'direccion_f1',
            [
                'attribute' => 'fk_ocupacion',
                'label' => 'Ocupacion',
                'value' => function ($model) {
                    return $model->fkOcupacion ? $model->fkOcupacion->nombre_ocupacion : 'Sin asignar';
                },
            ],
        ],
        ]) ?>
    </div>
</div>
<div class="col-md-6">
    <div class="detail-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                
                [
                    'attribute' => 'fk_distrito',
                    'label' => 'Distrito',
                    'value' => function ($model) {
                        return $model->fkDistrito ? $model->fkDistrito->nombre_distrito : 'Sin asignar';
                    },
                ],
                [
                    'attribute' => 'fk_distrito',
                    'label' => 'Municipio',
                    'value' => function ($model) {
                        return $model->fkDistrito ? $model->fkDistrito->fkMunicipio->nombre_municipio : 'Sin asignar';
                    },
                ],
                [
                    'attribute' => 'fk_distrito',
                    'label' => 'Departamento',
                    'value' => function ($model) {
                        return $model->fkDistrito ? $model->fkDistrito->fkMunicipio->fkDepartamento->nombre_departamento : 'Sin asignar';
                    },
                ],
            'numero_pariente',
            'nombre_pariente',

            'lugar_trabajo',
            'horario_laboral',
        ],
    ]) ?>
            </div>
        </div>
        
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
<?php endif; ?>

    </div>
