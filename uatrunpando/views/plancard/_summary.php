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
						 		//                                 'user_id',
						 				[
						 						'label' =>"App User",
						 						'attribute' => 'field_force',
						 				],
						 				'reports_to',
						 				'active_days',
						 				'inactive_days',
						 				[
						 				'attribute' => 'hour',
						 				'label'=> 'Hours (H:M:S)',
						 				'enableSorting' => false,
						 				'format'=> 'raw',
						 				'value'=> function ($data) {
						 					return $data['hour'];
						 								}
						 				],
						 				[
						 				'attribute' => 'time',
						 				'label'=> 'Average Hours (H:M:S)',
						 				'enableSorting' => false,
						 				'format'=> 'raw',
						 				'value'=> function ($data) {
						 					return $data['avg_hour'];
						 				}
						 				],
						 				[
						 				'attribute' => 'distance',
						 				'label'=> 'Distance Travelled (Km)',
						 				'enableSorting' => false,
						 				'format'=> 'raw',
						 				'value'=> function ($data) {
						 				return round($data['distance'],2);
						 				}
						 				],
						 				[
						 				'attribute' => 'average_distance',
						 				'label'=> 'Avg Distance Travelled (Km)',
						 				'enableSorting' => false,
						 				'format'=> 'raw',
						 				'value'=> function ($data) {
						 					return abs(round($data['average_distance'],2));
						 				}
						 				],
						 				[
						 						'label' =>"No.of Village Visits",
						 						'attribute' => 'villages',
						 				],
						 				[
						 						'label' =>"Villages Visited",
						 						'attribute' => 'villages_unique',
						 				],
						 				[
						 						'label' =>"No.of Partner Visits",
						 						'attribute' => 'partners',
						 				],
						 				[
						 						'label' =>"Partners Visited",
                            				'attribute' => 'partners_unique',
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