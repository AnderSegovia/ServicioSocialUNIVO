<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblCarrera $model */

$this->title = 'Create Tbl Carrera';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-carrera-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
