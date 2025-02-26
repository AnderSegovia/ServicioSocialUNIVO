<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblNames $model */

$this->title = 'Create Tbl Names';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Names', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-names-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
