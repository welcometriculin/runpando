<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PlanCards */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Plan Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-cards-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?php 
	if(Yii::$app->session->hasFlash('Card has been created')){?>
	        <div class="alert alert-success">
			Card has been created succesfully
        	</div>
	<?php }elseif(Yii::$app->session->hasFlash('approved')){ ?>
		
		<div class="alert alert-success">
		Card has been approved
		</div>
	<?php }elseif(Yii::$app->session->hasFlash('rejected')){ ?>
	<div class="alert alert-danger">
		Card has been rejected
		</div>
		<?php }?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'guid',
            'assign_to',
            'card_type',
            'planned_date',
            'plan_type',
            'crop_name',
            'channel_partner',
            'village_name',
            'activity',
            'distance_travelled',
            'status',
            'created_date',
            'created_by',
            'updated_date',
            'updated_by',
     				[
        	'label' => 'picture1',
        	'value' => $data['picture1']
        			],
        ],
    ]) ?>

</div>
