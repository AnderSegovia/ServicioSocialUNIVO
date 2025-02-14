<?php
$this->context->layout = 'blank';

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TblF1 $model */

$this->title = 'Create Ficha F1';
$this->params['breadcrumbs'][] = ['label' => 'Tbl F1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-f1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form2', [
        'model' => $model,
    ]) ?>

</div>
