<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoProyecto $model */

$this->title = 'Update Tbl Estado Proyecto: ' . $model->id_estado_proyecto;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Estado Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_estado_proyecto, 'url' => ['view', 'id_estado_proyecto' => $model->id_estado_proyecto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-estado-proyecto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
