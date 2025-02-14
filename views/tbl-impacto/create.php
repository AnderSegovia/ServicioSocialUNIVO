<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblImpacto $model */

$this->title = 'Create Tbl Impacto';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Impactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-impacto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
