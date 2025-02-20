<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblCargos $model */

$this->title = 'Update Tbl Cargos: ' . $model->id_cargos;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cargos, 'url' => ['view', 'id_cargos' => $model->id_cargos]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-cargos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
