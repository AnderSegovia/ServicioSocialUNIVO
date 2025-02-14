<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblPivotef1 $model */

$this->title = 'Update Tbl Pivotef1: ' . $model->id_pivotef1;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pivotef1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pivotef1, 'url' => ['view', 'id_pivotef1' => $model->id_pivotef1]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-pivotef1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
