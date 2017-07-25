<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FormBuilder */

$this->title = $model->form_builder_id;
$this->params['breadcrumbs'][] = ['label' => 'Form Builders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-builder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->form_builder_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->form_builder_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'form_builder_id',
            'form_builder_activity_id',
            'step',
            'required',
            'mandatory',
            'label',
            'data_type',
            'validation_type',
            'created_by',
            'updated_by',
            'created_date',
            'updated_date',
        ],
    ]) ?>

</div>
