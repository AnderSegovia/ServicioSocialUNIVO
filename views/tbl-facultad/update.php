<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblFacultad $model */

$this->title = 'Update Tbl Facultad: ' . $model->id_facultad;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Facultads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_facultad, 'url' => ['view', 'id_facultad' => $model->id_facultad]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-facultad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
