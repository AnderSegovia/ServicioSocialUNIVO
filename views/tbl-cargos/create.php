<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblCargos $model */

$this->title = 'Create Tbl Cargos';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-cargos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
