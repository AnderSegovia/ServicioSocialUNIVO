<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblCarrera $model */

$this->title = 'Update Tbl Carrera: ' . $model->id_carrera;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_carrera, 'url' => ['view', 'id_carrera' => $model->id_carrera]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-carrera-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
