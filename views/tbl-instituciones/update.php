<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblInstituciones $model */

$this->title = 'Update Tbl Instituciones: ' . $model->id_institucion;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Instituciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_institucion, 'url' => ['view', 'id_institucion' => $model->id_institucion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-instituciones-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
