<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblF1 $model */

$this->title = 'Update Tbl F1: ' . $model->id_f1;
$this->params['breadcrumbs'][] = ['label' => 'Tbl F1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_f1, 'url' => ['view', 'id_f1' => $model->id_f1]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-f1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
