<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FormBuilder */

$this->title = 'Update Form Builder: ' . ' ' . $model->form_builder_id;
$this->params['breadcrumbs'][] = ['label' => 'Form Builders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->form_builder_id, 'url' => ['view', 'id' => $model->form_builder_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="form-builder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
