<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblCasossuspencion $model */

$this->title = 'Update Tbl Casossuspencion: ' . $model->id_casos;
$this->params['breadcrumbs'][] = ['label' => 'Tbl Casossuspencions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_casos, 'url' => ['view', 'id_casos' => $model->id_casos]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbl-casossuspencion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
