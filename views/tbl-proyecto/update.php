<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblProyecto $model */

$this->title = 'Update Proyecto: ' . $model->id_proyecto;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_proyecto, 'url' => ['view', 'id_proyecto' => $model->id_proyecto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-proyecto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
