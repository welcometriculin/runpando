<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TravelLog */

$this->title = 'Update Travel Log: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Travel Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="travel-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
