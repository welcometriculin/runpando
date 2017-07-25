<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Roles;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users List';
$this->params['breadcrumbs'][] = $this->title;
$icadmin_role_id = Roles::ICADMIN;
?>
<div class="users-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<?php 
	if (Yii::$app->session->hasFlash('users-created')) {?>
	        <div class="alert alert-success">
			User details added successfully
        	</div>
	<?php 
	} else if (Yii::$app->session->hasFlash('users-updated')) {
	?>
		    <div class="alert alert-success">
            User details updated successfully
        	</div>
	<?php 
	} else if (Yii::$app->session->hasFlash('users-deleted')) {
	?>
   	        <div class="alert alert-danger">
            User details deleted successfully
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('users-activated')) {
	?>
   	        <div class="alert alert-success">
            User has been activated successfully
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('users-deactivated')) {
	?>
   	        <div class="alert alert-danger">
            User has been deactivated successfully
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-kgadmin-roleid')) {
	?>
   	        <div class="alert alert-danger">
           You have entered wrong Role ID.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-icadmin-roleid')) {
	?>
   	        <div class="alert alert-danger">
           You have entered wrong Role ID.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-roleid-notmatch')) {
	?>
   	        <div class="alert alert-danger">
           Role ID is not matching.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-empty')) {
	?>
   	        <div class="alert alert-danger">
           Some fields are empty. Please fill.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-email-exist')) {
	?>
   	        <div class="alert alert-danger">
            Email Id already exists. Please try another.
            </div>
    <?php 
	}  else if (Yii::$app->session->hasFlash('bulkfields-phone-number-exist')) {
	?>
   	        <div class="alert alert-danger">
            Phone number already exists. Please try another.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-duplicate-email')) {
	?>
   	        <div class="alert alert-danger">
            Duplicate Email Id's found.
            </div>
    <?php 
	}  else if (Yii::$app->session->hasFlash('bulkfields-duplicate-phone-number')) {
	?>
   	        <div class="alert alert-danger">
            Duplicate Phone numbers found.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-duplicate-employeeids')) {
	?>
   	        <div class="alert alert-danger">
            Duplicate Employee Id's found.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-same-employeeids')) {
	?>
   	        <div class="alert alert-danger">
            Reporting employee's should not be same.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-manager-ff')) {
	?>
   	        <div class="alert alert-danger">
            Manger can't be reporting to field force employee.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-ff-ff')) {
	?>
   	        <div class="alert alert-danger">
            Field force employee can't be reporting to field force employee.
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-success')){
	?>
   	        <div class="alert alert-success">
            Users uploaded successfully
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('phone-number-format')) {
	?>
			<div class="alert alert-danger">
            Phone number format is wrong
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('employee-number-format')) {
	?>
			<div class="alert alert-danger">
            Employee ID format is wrong
            </div>
    <?php 
	} else if (Yii::$app->session->hasFlash('not valid email address')) { 
	?>
            <div class="alert alert-danger">
            Email is not valid
            </div>
            	
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-employee_number-exist')) { 
	?>
            <div class="alert alert-danger">
            Employee ID already exists.
            </div>
            
    <?php 
	} else if (Yii::$app->session->hasFlash('bulkfields-spaces-occured')) { 
	?>
            <div class="alert alert-danger">
            White Spaces are Occured. Please remove them and try again.
            </div>
            	
    <?php 
	}
	?>
	<p>
	<?php if (Yii::$app->user->identity->roleid == $icadmin_role_id) {?>
     <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'bulkfile')->fileInput(); ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'saved']) ?>

	<?php ActiveForm::end() ?>   
	<?php } ?>
    <div class="clearfix pull-right">
    <?php if(in_array("create", $linkactions)){?>
		<a href="<?php echo Url::to(['create']);?>" type="button" class="btn btn-primary mb20"><i class="fa fa-plus"></i> New User</a>
	<?php } ?>
	</div>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
    	'summary'=>'',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
    		[
    		'attribute'=>'first_name',
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data)use ($linkactions){
    				return (in_array("view", $linkactions))? Html::a(Html::encode(ucfirst($data->first_name)),['view' ,'id'=> $data->id]) : Html::a(Html::encode(ucfirst($data->first_name)), ['title'=>'Click to view']);
    			},
    		],
    		[
    		'attribute' => 'employee_number',
    		'label'=> 'Employee Id',
    		'enableSorting' => false,
    		],
    		[
    		'attribute'=>'email_address',
    		'label'=> 'Email Id',
    		'enableSorting' => false,
    		],
    		[
    		'attribute' => 'phone_number',
    		'label'=> 'Phone No.',
    		'enableSorting' => false,
    		],
    		//'roles.role_name',
    		[
    		'attribute' => 'roleid',
    		'label'=> 'Role',
    		'enableSorting' => false,
    		'value' => function($data){
			return Html::encode(ucwords($data->role->role_name));
			},
			],
    		[
			'attribute' => 'area_of_operation',
    		'enableSorting' => false,
			'value' => function($data){
				return Html::encode(ucfirst($data->area_of_operatoin));
			},
    		],
			[
			'attribute' => 'status',
			'enableSorting' => false,
			'format'=>'raw',
			'value'=>function($data){
    		return Html::tag('span', ucfirst($data->status), ['class' => ($data->status=='active') ? 'approved' : 'rejected']);
				},
			],
    		['class' => 'yii\grid\ActionColumn', 'visible' => ($actioncolumns != '')? true:false,
    		 'header'=> 'Action',
    		 'template'=>'{'.$actioncolumns.'}',
    		 'buttons'=>[
    		 'update' => function ($url, $model) {
    			    return Html::a('<span class="fa fa-pencil-square-o"></span>', $url, ['title' => Yii::t('yii', 'update')]);
    				},
    		 'delete' => function ($url, $model) {
					$delete_disabled = '<span class="fa fa-trash-o" disabled></span>';
    			    return $model["status"] == 'active'? $delete_disabled : Html::a('<span class="fa fa-trash-o"></span>', '#', ['title' => Yii::t('yii', 'delete'),
							'id'=>'del_id',
							//'data-confirm'=>'Are you sure you want to delete this item?',
							'delete_id' => $url,
							//'data-method' => 'POST',
							'data-toggle'=>'modal',
							'data-target'=>'#myModal']);
    			    },
    		    ]
    		 ],
            //'id',
            //'guid',
            //'employee_number',
            //'first_name',
            //'last_name',
            // 'designation',
            // 'phone_number',
            // 'email_address:email',
            // 'password',
            // 'roleid',
            // 'input_company_id',
            // 'reporting_user_id',
            // 'photo',
            // 'photo_path',
            // 'state',
            // 'district',
            // 'head_quarters',
            // 'area_of_operatoin:ntext',
            // 'status',
            // 'access_token',
            // 'auth_key',
            // 'created_date',
            // 'created_by',
            // 'updated_date',
            // 'updated_by',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<p>Are you sure you want to delete User?</p>
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