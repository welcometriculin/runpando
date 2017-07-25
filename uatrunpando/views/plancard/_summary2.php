<?php
use yii\helpers\Html;
use yii\base\Widget;
use yii\grid\GridView;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>
<form class="form-horizontal">
	<div class="">
		<div class="profile-ilk-user">
			<div class="white-bg admin-table clearfix">
				<div class="">
					<div class="table-responsive">
						<?php \yii\widgets\Pjax::begin(['id' => $pjax_id, 
                            'timeout' => false, 
                            'enablePushState' => false, 
                            'clientOptions' => ['method' => 'POST']]); 
						?>
						 <?= GridView::widget([
                            'dataProvider' => $userRoleDataProvider,
						 		'pager' => [
						 				'firstPageLabel' => 'First',
						 				'lastPageLabel' => 'Last',
						 				'maxButtonCount'=>3,
						 		],
                            'columns' => [
                            		[
                            		'label' =>"App User",
                            		'attribute' => 'field_force',
                            		],
                            	'reports_to',
                            		[
                            		'label' =>"Head Quarters",
                            		'attribute' => 'head_quarter',
                            		],
                            		[
                            		'label' =>"Built Plans",
                            		'attribute' => 'plan_build',
                            		],
                            		[
                            		'label' =>"Assigned Plans",
                            		'attribute' => 'plan_assign',
                            		],
                            		[
                            		'label' =>"Rejected Plans",
                            		'attribute' => 'plan_rejected',
                            		],
                            		[
                            		'label' =>"Pending Plans",
                            		'attribute' => 'plan_pending',
                            		],
                            		
                            		[
                            		'label' =>"Submitted Plans",
                            		'attribute' => 'plan_submitted',
                            		],
                            		
                            							
                            ],
                        ]);
						/*  echo \yii\widgets\LinkPager::widget([
						 		'pagination' => $pages,
						 ]); */
                        ?>
                       
						<?php Pjax::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</form>