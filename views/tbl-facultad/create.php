<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblFacultad $model */

$this->title = 'Create Tbl Facultad';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Facultads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-facultad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
