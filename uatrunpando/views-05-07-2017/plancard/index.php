<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\Sort;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plans';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('_search', ['model' => $searchModel,'data' =>$data]);  ?>
<?php if($menu > 0) {?> 
<div class="pull-right build_btn_main">
		<a href="<?php echo Url::to(['plancard/create']);?>" type="button" class="btn btn-primary mb20 build_btn"><i class="fa fa-plus"></i> Build Plan</a>
			</div>
			<?php } ?>
			<div class="clearfix"></div>
<div class="plan-cards-index">
<?php 
	if(Yii::$app->session->hasFlash('plan-create')){?>
	        <div class="alert alert-success">
			Plancard Created  successfully
        	</div>
	<?php 
	}
	else if(Yii::$app->session->hasFlash('plan-approve')){
	?>
		    <div class="alert alert-success">
           Plan has been approved
        	</div>
	<?php 
	}
	else if(Yii::$app->session->hasFlash('plan-reject')){
	?>
   	        <div class="alert alert-danger">
            Plan Card Rejected
            </div>
     <?php }
     else if(Yii::$app->session->hasFlash('plan-update')){ ?>
     	<div class="alert alert-success">
            Plan Card has been Updated successfully
            </div>
    <?php  } elseif(Yii::$app->session->hasFlash('plan-delete')){ ?>
     	<div class="alert alert-success">
            Plan Card has been deleted successfully
            </div>
    <?php  }
     ?>
    
    <?php 
	
		
// echo '<pre>';print_r($dataProvider);exit;// echo $this->render('_search', ['model' => $searchModel]); ?>
			
 
 
	<div class="col-sm-12">
	<div class="row">
	<div class="table-responsive">
	

<?php Pjax::begin([ 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']])  ?>							
	    <?= GridView::widget([
       'dataProvider' => $dataProvider,
    	//'filterModel' => $searchModel,
    	//	'filterSelector' => '#' . Html::getInputId($delete, 'pagesize'),
    		'pager' => [
    				'firstPageLabel' => 'First',
    				'lastPageLabel' => 'Last',
    		],
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
       					'label' =>"Date",
       					'attribute' => 'Date',
       						'value'=>function($data){
       							$date = new DateTime($data["planned_date"]);
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
	           	return Html::a($data["activity"] == 'Channel Card'?'Partner Visit':$data["activity"], Url::to(['plancard/activity/'.$id]), ['title' =>$data["activity"] == 'Channel Card'?'Partner Visit':$data["activity"]]);   				},
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
	           	'label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop'),
	           	'attribute' => 'Crop',
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
           		[
           		'attribute' => 'created_by',
           		'enableSorting' => false,
           		'value'=>function($data){
           		return ucfirst(substr($data["createdby"],0,10));
           		}		
           		], 
           		[
           		'attribute' => 'assign_to',
           		'label' => 'Assigned To',
           		'enableSorting' => false,
           		'value'=>function($data){
           		return ucfirst(trim($data["assignee"], '`'));
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
//            'title',
//            'author',
//            'created_on',
           ['class' => 'yii\grid\ActionColumn',
        				'header'=>'Action',
        				'template'=>'{update}{delete}',
        				'buttons'=>[
        						'update' => function ($url, $data) {
        						$url='update/'.$data['guid'];
        						$dis='<span class="fa fa-pencil-square-o" disabled></span>';
        						return $data["status"]=='submitted'?$dis:Html::a('<span class="fa fa-pencil-square-o"></span>', $url, [
        								'title' => Yii::t('yii', 'Update'),
        						]);
        				
        						},
        						'delete' => function ($url, $data) {
        						$url='delete/'.$data['id'];
        						return Html::a('<span class="fa fa-trash-o"></span>', '#', [
        								'title' => Yii::t('yii', 'Delete'),
        								'id'=>'del_id',
//         								'data-confirm'=>'Are you sure you want to delete this item?',
        								'delete_id' => $url,
        								//'data-method' => 'POST',
        								'data-toggle'=>'modal',
        								'data-target'=>'#myModal'
        								
        						]);
        						
        						}
        								]
        								],
       ],
   ]); ?>
    <?php Pjax::end(); ?>
 </div>
 </div>
 </div>

 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<p>Are you sure you want to Delete Plan?</p>
		  </div>
		  <div class="modal-footer">
			<a href="javascript:void(0);"  type="button" class="btn btn-primary" id="result5">Okay</a>
			<a type="button" class="btn btn-danger" data-dismiss="modal">Cancel</a>
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
