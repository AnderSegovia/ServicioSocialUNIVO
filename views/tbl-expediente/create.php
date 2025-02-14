<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblExpediente $model */

$this->title = 'Create Tbl Expediente';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-expediente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
