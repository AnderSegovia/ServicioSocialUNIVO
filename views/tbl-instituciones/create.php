<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblInstituciones $model */

$this->title = 'Create Tbl Instituciones';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Instituciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-instituciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
