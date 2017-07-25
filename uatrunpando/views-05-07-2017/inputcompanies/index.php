<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InputCompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organizations';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
						<hr class="mrg_btn" />
<div class="input-companies-index">

   <!--  <h1><?/*= Html::encode($this->title)*/ ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php 
	if(Yii::$app->session->hasFlash('company-created')){?>
	        <div class="alert alert-success">
            Organization details has been created successfully
        	</div>
	<?php 
	} else if(Yii::$app->session->hasFlash('company-updated')){
	?>
		    <div class="alert alert-success">
            Organization details updated successfully
        	</div>
	<?php 
	} else if(Yii::$app->session->hasFlash('company-deleted')){
	?>
   	        <div class="alert alert-success">
            Organization details deleted successfully
            </div>
    <?php 
	} else if(Yii::$app->session->hasFlash('company-activated')){
	?>
   	        <div class="alert alert-success">
            Organization has been activated successfully
            </div>
    <?php 
	} else if(Yii::$app->session->hasFlash('company-deactivated')){
	?>
   	        <div class="alert alert-danger">
            Organization has been deactivated successfully
            </div>
    <?php 
	}
	?>
        <?php /*if(in_array("create", $linkactions)){?>
        <?= Html::a('Create Input Companies', ['create'], ['class' => 'btn btn-success']) ?>
        <?php }*/?>
        	<div class="pull-right">
        	<?php if(in_array("create", $linkactions)){?>
		<a href="<?php echo Url::to(['create']);?>" type="button" class="btn btn-primary mb20"><i class="fa fa-plus"></i> New Organization</a>
			<?php } ?>
			</div>
			<div class="clearfix"></div>
			<div class="col-sm-12">
	<div class="row">
	<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       //'filterModel' => $searchModel,
    	//'summary'=>'',
    		'emptyCell'=>'-',
    		'emptyText' => 'N/A',
    		'pager' => [
    				'firstPageLabel' => 'First',
    				'lastPageLabel' => 'Last',
    		],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
    		[
    		'attribute' => 'person_name',
    		'enableSorting' => false,
    		'value'=>function($data){
    			return ($data->person_name ? $data->person_name : 'N/A');
    		},
    		],
    		[
    		'attribute' => 'designation',
    		'enableSorting' => false,
    		'value'=>function($data){
    			return ($data->designation ? $data->designation : 'N/A');
    		},
    		],
    		[
    		'attribute'=>'organization_name',
    		'label' => 'Organization',
    		'enableSorting' => false,
    		'format'=> 'raw',
    			'value'=> function ($data) use ($linkactions){
    				return $data->organization_name?(in_array("view", $linkactions))? Html::a(Html::encode($data->organization_name),['view' ,'id'=> $data->guid]):Html::a(Html::encode($data->organization_name)):'N/A';
    			},
    		],
    		[
    		'attribute' => 'phone_number',
    		'label' => 'Mobile No',
    		'enableSorting' => false,
    		'value'=>function($data){
    			return $data->phone_number;
    		},
    		], 	
    		/*[
    		'attribute' => 'contact_email',
    		'label' => 'Email Address',
    		'enableSorting' => false,
    		'value'=>function($data){
    			return $data["contact_email"];
    		},
			],*/
    		[
    		'attribute' => 'number_of_licences',
    		'label' => 'Number Of App Users',
			'enableSorting' => false,
   			'value'=>function($data){
   				return ($data->number_of_licences ? $data->number_of_licences : 'N/A');
   			},
    		],
    		[
    		'attribute' => 'paid_amount',
    		'label' => 'Payment Made',
			'enableSorting' => false,
    		'value'=>function($data){
    			return ($data->paid_amount ? $data->paid_amount : 'N/A');
    		},
    		],
    		[
    		'attribute' => 'status',
    		'enableSorting' => false,
    		'format'=>'raw',
    		'value'=>function($data){
	    		if($data->status == 'active'){
	    			$data->status = 'Active';
	    		}
	    		else{
	    			$data->status = 'Inactive';
	    		}
    		return Html::tag('span', $data->status, ['class' => ($data->status =='Active') ? 'approved' : 'rejected']);
        	},
    		],
    		['class' => 'yii\grid\ActionColumn', 'visible' => ($actioncolumns != '')? true:false,
    		'header'=>'Action',
    		'template'=>'{'.$actioncolumns.'}',
    		'buttons'=>[
	    		'update' => function ($url, $model) {
				$url = Url::to(['update', 'id' => $model->guid]);
	    		return Html::a('<span class="fa fa-pencil-square-o"></span>', $url, ['title' => Yii::t('yii', 'update')]);
				},
	    		'delete' => function ($url, $model) {
				$url = Url::to(['delete', 'id' => $model->guid]);
				$delete_disabled = '<span class="fa fa-trash-o" disabled></span>';
	    		return $model["status"] == 'Active'? $delete_disabled : Html::a('<span class="fa fa-trash-o"></span>', '#', ['title' => Yii::t('yii', 'delete'),
								'id'=>'del_id',
        						//'data-confirm'=>'Are you sure you want to delete this item?',
								'delete_id' => $url,
								//'data-method' => 'POST',
								'data-toggle'=>'modal',
								'data-target'=>'#myModal']);
	    		}
    		  ]
    		 ],
    		        										
           // 'id',
           // 'guid',
           // 'organization_name',
           // 'person_name',
           // 'contact_email:email',
            // 'phone_number',
            // 'paid_amount',
            // 'number_of_licenses',
            // 'created_date',
            // 'created_by',
            // 'updated_date',
            // 'updated_by',
    	],
    ]); ?>
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
			<p>Are you sure you want to Delete Organization?</p>
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
	$('#result5').attr('href','');
	$('#del_id').live('click',function(){
		var url = $(this).attr('delete_id');
		$('#result5').attr('href',url);
	});
});
JS;
$this->registerJs($script);
?>