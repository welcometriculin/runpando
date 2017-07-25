<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Designations */

$this->title = $model->designation_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Designations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->designation_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->designation_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'designation_id',
            'designation_name',
            'company_id',
            'created_by',
            'updated_by',
            'created_date',
            'updated_date',
        ],
    ]) ?>

</div>
