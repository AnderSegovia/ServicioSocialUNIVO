<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblActividad $model */

$this->title = 'Update Tbl Actividad: ' . $model->id_actividad;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_actividad, 'url' => ['view', 'id_actividad' => $model->id_actividad]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-actividad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
