<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblPivote $model */

$this->title = 'Update Tbl Pivote: ' . $model->id_pivote;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pivotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pivote, 'url' => ['view', 'id_pivote' => $model->id_pivote]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-pivote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
