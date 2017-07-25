<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FormBuilderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Form Builders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-builder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Form Builder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'form_builder_id',
            'form_builder_activity_id',
            'step',
            'require',
            'mandatory',
            // 'label',
            // 'data_type',
            // 'validation_type',
            // 'created_by',
            // 'updated_by',
            // 'created_date',
            // 'updated_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
