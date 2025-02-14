<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblEstadoProyecto $model */

$this->title = 'Create Tbl Estado Proyecto';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Estado Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-estado-proyecto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
