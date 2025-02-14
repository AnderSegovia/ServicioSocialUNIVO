<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblPivotef1 $model */

$this->title = 'Create Tbl Pivotef1';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pivotef1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-pivotef1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
