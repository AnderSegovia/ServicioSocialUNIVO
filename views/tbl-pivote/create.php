<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblPivote $model */

$this->title = 'Create Tbl Pivote';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Pivotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-pivote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
