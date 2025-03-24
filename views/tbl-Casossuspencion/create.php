<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblCasossuspencion $model */

$this->title = 'Create Tbl Casossuspencion';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Casossuspencions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-casossuspencion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
