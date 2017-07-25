<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\Sort;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-sm-12">
	<div role="tabpanel" class="tabs border-pink history">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#LeaveRequest"
				aria-controls="home" role="tab" data-toggle="tab">Plan History</a></li>
			<li role="presentation" class=""><a href="#LeaveCalender"
				aria-controls="home" role="tab" data-toggle="tab">Summary</a>
			</li>

		</ul>
		<div class="tab-content clearfix">
			<div role="tabpanel" class="tab-pane active" id="LeaveRequest">
				<div class="panel-group" id="accordion" role="tablist"
					aria-multiselectable="true">
					<div class="panel-body panel-bg">

						<div class="plan-cards-index">

							<?php 


// echo '<pre>';print_r($dataProvider);exit;// echo $this->render('_search', ['model' => $searchModel]); ?>



							<div class="col-sm-12">
								<div class="row">

									<?php echo $this->render('_search', ['model' => $searchModel,'data' => $data]); ?>
									<div class="table-responsive">
										<?= GridView::widget([
												'dataProvider' => $dataProvider,
												'pager' => [
														'firstPageLabel' => 'First',
														'lastPageLabel' => 'Last',
												],
												//'filterModel' => $searchModel,
												//	'filterSelector' => '#' . Html::getInputId($delete, 'pagesize'),
												'layout' => "{summary}\n{items}\n{pager}",
												'columns' => [
														//    ['class' => 'yii\grid\SerialColumn'],
														[
																'label' =>"Emp ID",
																'attribute' => 'Emp id',
																'value'=>function($data){
																return $data['employee_number'];
														}
														],
														[
																'label' =>"Plan Date",
																'attribute' => 'Date',
																'value'=>function($data){
																$date = new DateTime($data["planned_date"]);
																return $date->format('d/m/Y');
																	
														}
														],
														[
																'label' =>"Submit Date",
																'attribute' => 'Date',
																'value'=>function($data){
																$date = new DateTime($data["updated_date"]);
																return $date->format('d/m/Y');
																	
														}
														],
														[
																'attribute' => 'plan_type',
																'format'=>'raw',
																'value'=>function($data){
																return Html::tag('span', ucfirst($data['plan_type']), ['class' => ($data['plan_type']=='adhoc') ? 'adhoc' : 'planned']);
														},
														//	'contentOptions' =>['style' => 'background-color:'.($data->status=='Approved') ? 'green' : 'red','class' => 'table_class'],
														'enableSorting' => false,
														],
															
														[
																'attribute' => 'activity',
																'format'=>'raw',
																'value'=>function($data){
																$id=$data['guid'];
																return Html::a($data["activity"] == 'Channel Card'?'Partner Visit':$data["activity"], Url::to(['plancard/activity/'.$id]), ['title' =>$data["activity"]]);
														},
														'enableSorting' => false,
														],
														[
																'label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village'),
																'attribute' => 'Village',
																'value'=>function($data){
																return ucwords($data["village_name"]);
														}
														],
														[
																//'label' =>"Crop",
																'label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop'),
																'value'=>function($data){
																return empty($data["crop_name"])?'N/A':ucwords($data["crop_name"]);
														}
														],
														[
																'label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product'),
																'attribute' => 'Product',
																'value'=>function($data){
																return empty($data["product_name"])?'N/A':ucwords($data["product_name"]);
														}
	           		],
	           		/* 	[
	           		 'attribute' => 'created_by',
	           				'enableSorting' => false,
	           				'value'=>function($data){
	           				return substr($data["createdby"],0,10);
	           				}
	           		], */
	           		[
	           				'attribute' => 'assign_to',
	           				'label' => 'Submitted By',
	           				'enableSorting' => false,
	           				'value'=>function($data){
	           				return ucfirst($data["assignee_name"]);
	           		}
	           		],
	           		/* [
	           		 'label' =>'Approval Status',
	           				'attribute' => 'plan_approval_status',
	           				'enableSorting' => false,
	           				'value'=>function($data){
	           				return $data["plan_approval_status"];
	           				}
	           		], */

	           		/*[
	           		 'attribute' => 'status',
	           				'format'=>'raw',
	           				'value'=>function($data){
	           				return Html::tag('div', $data['status'], ['style' => ($data['status']=='approved' ||$data['status']=='completed' ) ? 'background-color:#c7e0a7;border-radius:4px;text-align: center;' : 'background-color:#f4a89b;border-radius:4px;text-align: center;','class' => 'table_class']);
	           				},
	           				//	'contentOptions' =>['style' => 'background-color:'.($data->status=='Approved') ? 'green' : 'red','class' => 'table_class'],
	           				'enableSorting' => false,
	           		],*/
	           		/* [
	           		 'label' =>'Submission Status',
	           				'attribute' => 'status',
	           				'format'=>'raw',
	           				'value'=>function($data){
	           				if($data['status']=='not_submitted')
	           				{
	           				return "<span class='notsubmitted'>Not submitted</span>";
	           				}
	           				if($data['status']=='submitted')
	           				{
	           				return "<span class='approved'>Submitted</span>";
	           				}
	           				if($data['status']=='rejected')
	           				{
	           				return "<span class='rejected'>Rejected</span>";
	           				}
	           				//return Html::tag('span', ucwords(str_replace('_',' ',$data['status'])), ['class' => ($data['status']=='not_submitted' ||$data['status']=='submitted' ) ? 'approved' : 'rejected']);
	           				},
	           				//	'contentOptions' =>['style' => 'background-color:'.($data->status=='Approved') ? 'green' : 'red','class' => 'table_class'],
	           				'enableSorting' => false,
	           		], */
	           		/* ['class' => 'yii\grid\ActionColumn',
	           		 'header'=>'Action',
	           				'template'=>'{update}{delete}',
	           				'buttons'=>[
	           						'update' => function ($url, $data) {
	           						$url='update/'.$data['guid'];
	           						$dis='<span class="fa fa-pencil-square-o" disabled></span>';
	           						return $data["status"]=='submitted'?$dis:Html::a('<span class="fa fa-pencil-square-o"></span>', $url, [
	           								'title' => Yii::t('yii', 'update'),
	           						]);

	           				panel-body		},
	           						'delete' => function ($url, $data) {
	           						$url='delete/'.$data['id'];
	           						return Html::a('<span class="fa fa-trash-o"></span>', '#', [
	           								'title' => Yii::t('yii', 'delete'),
	           								'id'=>'del_id',
	           								//         								'data-confirm'=>'Are you sure you want to delete this item?',
	           								'delete_id' => $url,
	           								//'data-method' => 'POST',
	           								'data-toggle'=>'modal',
	           								'data-target'=>'#myModal'

	           						]);

	           						}
	           				]
	           		], */
												],
   ]); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="LeaveCalender">
				<div class="panel-group" id="accordion" role="tablist"
					aria-multiselectable="true">
					<div class="">
				<?php echo $this->render('_export', ['model' => $model,'data' => $data,'villageList' => $villageList]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>





<?php 

$script = <<< JS

$(document).ready(function(){
		
		$('select.pagination').on('change', function() {
    document.location.href = $(this).attr('data-change') + '?records=' + $(this).val();
});
		
	$('#result5').attr('href','');
	$('#del_id').live('click',function(){
	var url=$(this).attr('delete_id');
		$('#result5').attr('href',url);
});


});
JS;
$this->registerJs($script);
?>
