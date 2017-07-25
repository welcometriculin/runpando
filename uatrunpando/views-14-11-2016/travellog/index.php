<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Travellog;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TravelLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Travel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="travel-log">

	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
	<div class="table-responsive">
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
			'pager' => [
					'firstPageLabel' => 'First',
					'lastPageLabel' => 'Last',
			],
        //'filterModel' => $searchModel,
    	//'summary'=>"Showing {begin} - {end} of {totalCount} {page}",
    	'showHeader' => false,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
    		[
    		'attribute' => 'updated_date',
    		'label'=> false,
    		'format'=>'raw',
    		'enableSorting' => false,
    		'value'=> function ($data) {
    			$date = new DateTime($data["updated_date"]);
    			//return $date->format('d/m/Y');
    			return '<div class="date"><span>'.$date->format('D').'</span></br><span>'.$date->format('d').' '.$date->format('M').'</span></div>';
    			 
    		}
    		],
    		[
    		'attribute' => 'assign_to',
    		'label'=> false,
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return Html::a(Html::tag('span', Html::encode(ucwords($data['first_name'])), ['class' =>'plans']), Url::to(['travellog/view/'.$data['guid'].'/'.substr($data["updated_date"],0,10)]), ['title' => $data['first_name']]);
    		//return Html::a(Html::tag('span', Html::encode(ucwords($data['first_name'])), ['class' =>'plans']), ['view' ,'id'=> $data['guid'].'/'.$data["updated_date"]]);
    		}
    		],
    		[
    		'attribute' => 'plan_card_count',
    		'label'=> false,
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return '<span class="plans">'. trim($data['plan_card_count'], '`'). ' Plan(s)</span><br /><span class="plan-comp">Completed</span>';
    		}
    		],
    		/* [
    		'attribute' => 'distance_travelled',
    		'label'=> false,
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return '<span class="travelled">'.substr($data['distance_travelled'], 0 ,strpos($data['distance_travelled'], '.')+5).' kms</span></br><span class="travelled">Travelled</span>';
    		}
    		], */
    		[
    		'attribute' => 'distance_travelled',
    		'label'=> false,
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return '<span class="travelled">'.Travellog::travellogsumdistance($data['assign_to'], $data["updated_date"]).' kms</span><span class="travelled">Travelled</span>';
    		}
    		],
            //'id',
            //'guid',
            //'assign_to',
            //'card_type',
            //'planned_date',
            // 'plan_type',
            // 'crop_name',
            // 'product_name',
            // 'channel_partner',
            // 'village_name',
            // 'activity',
            // 'distance_travelled',
            // 'status',
            // 'plan_approval_status',
            // 'created_date',
            // 'created_by',
            // 'updated_date',
            // 'updated_by',
            // 'is_deleted',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
	<!--<div class="row">
		<div class="col-sm-4 form-inline userlist mt20">
			<label>Display</label> <select class="form-control">
				<option>10</option>
				<option>20</option>
				<option>30</option>
				<option>All</option>
			</select> <label>per Page</label>
		</div>
	</div>-->
</div>
