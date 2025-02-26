<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblNames $model */

$this->title = 'Update Tbl Names: ' . $model->id_names;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_names, 'url' => ['view', 'id_names' => $model->id_names]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-names-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
