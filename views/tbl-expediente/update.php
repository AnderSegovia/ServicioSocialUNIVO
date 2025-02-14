<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblExpediente $model */

$this->title = 'Update Tbl Expediente: ' . $model->id_expediente;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_expediente, 'url' => ['view', 'id_expediente' => $model->id_expediente]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-expediente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
