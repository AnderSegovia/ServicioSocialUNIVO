<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblActividad $model */

$this->title = 'Create Tbl Actividad';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Actividads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-actividad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
