<?php
$this->context->layout = 'blank';
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblAlumno $model */

$this->title = 'New Alumno';
$this->params['breadcrumbs'][] = ['label' => 'Tbl Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-alumno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form2', [
        'model' => $model,
    ]) ?>

</div>
