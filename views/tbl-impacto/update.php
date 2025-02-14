<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblImpacto $model */

$this->title = 'Update Tbl Impacto: ' . $model->id_impacto;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Impactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_impacto, 'url' => ['view', 'id_impacto' => $model->id_impacto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-impacto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
