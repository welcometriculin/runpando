<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\Roles;
use app\models\Users;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Profile';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Profile';
$kgadmin_role_id = Roles::KGADMIN;
$icadmin_role_id = Roles::ICADMIN;
//$reporting_user_name = \app\models\Users::getReportingUserName($model->id);
//echo "<pre/>";
//$reporting_user_name = Users::find($model->updated_by)->one();--Author gowtham(working)
$reporting_user_name = Users::getUpdatedby($model->updated_by);
//print_r($reporting_user_name); die();
$organization_details = \app\models\InputCompanies::getOrganizationprofile();
?>

<?php if (Yii::$app->session->getFlash('change-password-success')) {?>
<div class="alert alert-success login_alert">Password Changed
	Successfully</div>
<?php } elseif (Yii::$app->session->getFlash('change-password-failure')) {?>
<div class="alert alert-danger">Your account is not activated</div>
<?php }?>
<?php 
if (Yii::$app->session->hasFlash('users-updated')) {
	?>
<div class="alert alert-success">User details updated successfully</div>
<?php 
}
elseif(Yii::$app->session->hasFlash('organization-updated')){
	?>
<div class="alert alert-success">Organization details updated
	successfully</div>
<?php }?>
<?php 
	if (Yii::$app->session->hasFlash('users-created')) {?>
<div class="alert alert-success">User details added successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('users-updated')) {
		?>
<div class="alert alert-success">User details updated successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('users-deleted')) {
		?>
<div class="alert alert-success">User details deleted successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('users-activated')) {
		?>
<div class="alert alert-success">User has been activated successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('users-deactivated')) {
		?>
<div class="alert alert-danger">User has been deactivated successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-kgadmin-roleid')) {
		?>
<div class="alert alert-danger">You have entered wrong Role ID.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-icadmin-roleid')) {
		?>
<div class="alert alert-danger">You have entered wrong Role ID.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-roleid-notmatch')) {
		?>
<div class="alert alert-danger">Role ID is not matching.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-empty')) {
		?>
<div class="alert alert-danger">Some fields are empty. Please fill.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-email-exist')) {
		?>
<div class="alert alert-danger">Email Id already exists. Please try
	another.</div>
<?php 
	}  elseif (Yii::$app->session->hasFlash('bulkfields-phone-number-exist')) {
		?>
<div class="alert alert-danger">Phone number already exists. Please try
	another.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-duplicate-email')) {
		?>
<div class="alert alert-danger">Duplicate Email Id's found.</div>
<?php 
	}  elseif (Yii::$app->session->hasFlash('bulkfields-duplicate-phone-number')) {
		?>
<div class="alert alert-danger">Duplicate Phone numbers found.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-duplicate-employeeids')) {
		?>
<div class="alert alert-danger">Duplicate Employee Id's found.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-same-employeeids')) {
		?>
<div class="alert alert-danger">Reporting employee's should not be same.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-manager-ff')) {
		?>
<div class="alert alert-danger">Manger can't be reporting to field force
	employee.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-ff-ff')) {
		?>
<div class="alert alert-danger">Field force employee can't be reporting
	to field force employee.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-success')) {
		?>
<div class="alert alert-success">Users uploaded successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('phone-number-format')) {
		?>
<div class="alert alert-danger">Phone number format is wrong</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('employee-number-format')) {
		?>
<div class="alert alert-danger">Employee ID format is wrong</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('not valid email address')) {
		?>
<div class="alert alert-danger">Email is not valid</div>

<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-employee_number-exist')) {
		?>
<div class="alert alert-danger">Employee ID already exists.</div>

<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-spaces-occured')) {
		?>
<div class="alert alert-danger">White Spaces are Occured. Please remove
	them and try again.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-first-name-format')) {
		?>
<div class="alert alert-danger">Name contains integers. Please remove.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('users-depend-plancard')) {
		?>
<div class="alert alert-danger">You Can't delete this user due to
	dependency actions.</div>
<?php 
	} elseif(Yii::$app->session->hasFlash('users-depend')) { ?>
<div class="alert alert-danger">This user have ff officers.</div>
<?php 
	} elseif(Yii::$app->session->hasFlash('bulkusers-wrong-file')) { ?>
<div class="alert alert-danger">File format wrong.</div>
<?php 
	} elseif(Yii::$app->session->hasFlash('bulkfields-reporting-user-not-exist')) { ?>
<div class="alert alert-danger"><?php echo Yii::$app->session->getFlash('bulkfields-reporting-user-not-exist')?></div>
<?php 
	} elseif(Yii::$app->session->hasFlash('bulkfields-firstname-duplicates')) { ?>
<div class="alert alert-danger">Some of the users have same names </div>
<?php 
	} elseif(Yii::$app->session->hasFlash('bulkfields-firstname-exist')) { ?>
<div class="alert alert-danger"><?php echo Yii::$app->session->getFlash('bulkfields-firstname-exist')?></div>
<?php 
	} elseif(Yii::$app->session->hasFlash('bulkfields-not-db-employeeids')) { ?>
<div class="alert alert-danger"><?php echo Yii::$app->session->getFlash('bulkfields-not-db-employeeids')?></div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkfields-file-empty')) {
	?>
		    <div class="alert alert-danger">
            Fields are empty. Please fill.
        	</div>
    <?php } elseif (Yii::$app->session->hasFlash('designation-empty')) {
	?>
		    <div class="alert alert-danger">
           Designation column empty (or) not matching to our company designations.
        	</div>
    <?php }  ?>

<div
	class="col-sm-12">
	<!-- <h1>Profile</h1> -->
	<div role="tabpanel" class="tabs">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#UserProfile"
				aria-controls="home" role="tab" data-toggle="tab">User Profile</a></li>
			<?php if ($organization_details !='') {?>
			<li role="presentation" class=""><a href="#CompanyProfile"
				aria-controls="home" role="tab" data-toggle="tab">Organization
					Profile</a></li>
			<?php } ?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content clearfix">

			<!-- --------------  USER PROFILE Tab-Panel ------------------- -->

			<div role="tabpanel" class="tab-pane active" id="UserProfile">
				<div class="panel-group" id="accordion" role="tablist"
					aria-multiselectable="true">
					<div class="panel-body panel-bg">
						<h3 class="panel-title">User Profile</h3>
						<div class="col-md-12 mt20 listview label_frm form_mobile">
							<div class="row">


								<div class="col-xs-12 col-md-6 padd_zero">
									<form class="form-horizontal" role="form">
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">First Name:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucfirst($model->first_name) ?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Last Name:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucfirst($model->last_name) ?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Email ID:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->email_address ?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Employee ID:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->employee_number?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Last Updated Date:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= date('d-m-Y, h:i:s',strtotime($model->updated_date));?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Last Updated By:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucwords($reporting_user_name['first_name']); ?>
											</label>
										</div>
									</form>
								</div>
								<div class="col-xs-12 col-md-5 padd_zero">
									<form class="form-horizontal" role="form">
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Phone No.:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->phone_number ?> </label>
										</div>
										<?php if (Yii::$app->user->identity->roleid == $icadmin_role_id) {?>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6  control-label">Designation:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucfirst($model->designation) ?>
											</label>
										</div>
										<?php } ?>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Reporting Manager:</label>
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?php if (Yii::$app->user->identity->roleid == $kgadmin_role_id || Yii::$app->user->identity->roleid == $icadmin_role_id) { 
												echo 'N/A';
											} else { echo ucwords($reporting_user_name['first_name'].' '.$reporting_user_name['last_name']);
											} ?> </label>
										</div>
										<?php if (Yii::$app->user->identity->roleid == $icadmin_role_id) { ?>
										<div class="form-group">
											<label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Web
												Users:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"> <?php if($userscount['web_users'] == 0) {
													echo $userscount['web_users'];
												} else {
													?> <a
												href="<?php echo Url::to(['export','type' =>'web']);?>"
												title="Web Users Export"><i class="fa fa-download" aria-hidden="true"></i>
												<?php echo $userscount['web_users'];?> </a>
												<?php }
												?>

											</label>
										</div>
										<div class="form-group">
											<label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">App
												Users:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"> <?php if($userscount['app_users'] == 0) {
													echo $userscount['app_users'];
												} else {
												 ?> <a
												href="<?php echo Url::to(['export','type' =>'app']);?>"
												title="App Users Export"><i class="fa fa-download" aria-hidden="true"></i>
												<?php echo $userscount['app_users'];?> </a>
												<?php }
											?>
										
										</div>
										<?php }?>
									</form>
								</div>
								<div class="col-xs-12 col-md-1 padd_zero">
									<button type="button" class="btn btn-primary pull-right btn_center"
										data-toggle="modal" data-target="#myModal">
										<i class="fa fa-edit"></i>Edit
									</button>
								</div>
							</div>


						</div>
					</div>
					<div class="panel-body panel-bg">
						<?php echo $this->render('_search', ['model' => $searchModel]); ?>
						<hr class="mrg_btn" />
						<div class="browse-form">
							<?php if (Yii::$app->user->identity->roleid == $icadmin_role_id) {?>
							<div class="row">
								<div class="bulkfile_main pull-left">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    	<div class="mr15 bulk-upload-mr0 pull-left float-none">
    		<?php /* ?><?= $form->field($model, 'bulkfile')->fileInput(['class'=>'file_btn form-control c-browse'])->label(false)  ; ?><?php */ ?>
    		<div class="bulk_upload_button">
    			<?= $form->field($model, 'bulkfile', ['template' => '<div id = "label_bulkupload">{label}</div>{input}<div id="inputuser-bulkfilename" style="color: #7f64b5"></div>
    			
        	{hint}{error}', 'options' => ['tag' => 'div', 'class' => 'custom-upload-button'], 'labelOptions' => ['class' => 'custom-upload-label']])->fileInput(['class'=>'file_btn form-control c-browse'])->label('<i aria-hidden="true" class="fa fa-upload"></i> &nbsp Upload Users')  ; ?>
    		</div>
    	</div>

    	<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'bulk','id'=>'bulk','value' => 'saved']) ?>

	<?php ActiveForm::end() ?>
	</div>
									<div class="pull-right bulkfile_temp clearfix btn_center">
										
											<a href="<?php echo Url::to(['download']);?>" type="button"
												class="btn btn-primary mb20"><i class="fa fa-download"
												aria-hidden="true"></i> Users Template</a>
											
											<?php if(in_array("create", $linkactions)){?>
											<a href="<?php echo Url::to(['create']);?>" type="button"
												class="btn btn-primary mb20"><i class="fa fa-plus"></i> New
												User</a>
											<?php } ?>
										

									</div>
								</div>
								<?php } ?>
								<div class="clearfix"></div>
							</div>
							<div class="table-responsive">
							<?= GridView::widget([
									'dataProvider' => $dataProvider,
									//'filterModel' => $searchModel,
									//'summary'=>'',
									'pager' => [
											'firstPageLabel' => 'First',
											'lastPageLabel' => 'Last',
									],
									'columns' => [
											//['class' => 'yii\grid\SerialColumn'],
											[
													'attribute'=>'first_name',
													'enableSorting' => false,
													'format'=> 'raw',
													'value'=> function ($data) use ($linkactions) {
													return (in_array("view", $linkactions))? Html::a(Html::encode(ucfirst($data->first_name)),['view' ,'id'=> $data->guid]) : Html::a(Html::encode(ucfirst($data->first_name)), ['title'=>'Click to view']);
							},
							],
							[
									'attribute' => 'employee_number',
									'label'=> 'Employee ID',
									'enableSorting' => false,
							],
							[
									'attribute'=>'email_address',
									'label'=> 'Email ID',
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
							'attribute' => 'designation_name',
							'label'=> 'Designation',
							'enableSorting' => false,
							'value' => function($data){
								if($data->designation_name == '') {
									return 'N/A';
								} else {
									return Html::encode(ucwords($data->designation_name));
								}
								
							},
							],
							[
									'attribute' => 'area_of_operation',
									'enableSorting' => false,
									'value' => function($data){
									return $data->area_of_operatoin ? Html::encode(ucfirst($data->area_of_operatoin)): 'N/A';
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
											$url = 'update/'.$model->guid;
											return Html::a('<span class="fa fa-pencil-square-o"></span>', $url, ['title' => Yii::t('yii', 'Update')]);
							},
							'delete' => function ($url, $model) {
							$url = 'delete/'.$model->guid;
							$delete_disabled = '<span class="fa fa-trash-o" disabled></span>';
							return $model["status"] == 'active'? $delete_disabled : Html::a('<span class="fa fa-trash-o"></span>', '#', ['title' => Yii::t('yii', 'Delete'),
									'id'=>'del_id',
									//'data-confirm'=>'Are you sure you want to delete this item?',
									'delete_id' => $url,
									//'data-method' => 'POST',
									'data-toggle'=>'modal',
									'data-target'=>'#myModaldelete']);
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
    ]); ?></div>
						</div>
					</div>
				</div>
				<!-- -------------- USER PROFILE Tab-Panel END ------------------- -->

				<!-- --------------  ORGANIZATION PROFILE Tab-Panel Start ------------------- -->

				<div role="tabpanel" class="tab-pane" id="CompanyProfile">
					<div class="panel-group" id="accordion" role="tablist"
						aria-multiselectable="true">
						<div class="panel-body panel-bg">
							<h3 class="panel-title">Organization Profile</h3>
							<div class="col-md-12 mt20 listview clearfix label_frm">
								 
								<div class="col-md-6 pull-left cmpy_details">
									<form class="form-horizontal" role="form">
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Company Name:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucwords($organization_details['organization_name']) ?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Company Email ID:</label>
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $organization_details['contact_email'] ?>
											</label>
										</div>
										<div class="form-group">
											<label class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Phone No.:</label> <label
												class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $organization_details['phone_number'] ?>
											</label>
										</div>
									</form>
								</div>
								<button type="button" class="btn btn-primary pull-right"
									data-toggle="modal" data-target="#myModalOrg">
									<i class="fa fa-edit"></i>Edit
								</button>
							</div>   
						</div>
					</div>
				</div>

				<!-- --------------  ORGANIZATION PROFILE Tab-Panel End ------------------- -->
			</div>

		</div>
		<div class="modal fade" id="myModaldelete" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to Delete User?</p>
					</div>
					<div class="modal-footer">
						<a href="javascript:void(0);" type="button"
							class="btn btn-primary" id="result5">Okay</a> <a type="button"
							class="btn btn-danger" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="panel-body panel-bg popup_edit">
						<?php $form = ActiveForm::begin(); ?>
						<div class="form row col-md-12 mt20">

							<div class="form-group col-xs-12 col-sm-6 col-md-6 mtm0">
								<label class="control-label required">First Name:</label>
								<?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label(false); ?>
							</div>
							<div class="form-group col-xs-12 col-sm-6 col-md-6 mtm0">
								<label class="control-label">Last Name:</label>
								<?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label(false); ?>
							</div>
							<div class="form row col-xs-12 col-sm-12">
								<div class="form-group col-xs-12 col-sm-6 col-md-6 mtm0">
									<label class="control-label required">Email ID:</label>
									<?= $form->field($model, 'email_address')->textInput(['maxlength' => true, 'readonly' => true])->label(false); ?>
								</div>
							</div>
						</div>

						<div class="hr"></div>

						<div class="form row col-md-12 mt20">
							<div class="form-group col-xs-12 col-sm-6 col-md-6 mtm0">
								<label class="control-label required">Phone No:</label>
								<?= $form->field($model, 'phone_number')->textInput(['maxlength' => true])->label(false); ?>
							</div>
							<?php if (Yii::$app->user->identity->roleid == $kgadmin_role_id || Yii::$app->user->identity->roleid == $icadmin_role_id) {?>
							<div class="form-group col-xs-12 col-sm-6 col-md-6 mtm0">
								<?php if (Yii::$app->user->identity->designation != '') {?>
								<label class="control-label required">Designation:</label>
								<?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'readonly' => true])->label(false); ?>
								<?php } ?>
							</div>
							<?php }?>
							<?php if (Yii::$app->user->identity->roleid != $kgadmin_role_id && Yii::$app->user->identity->roleid != $icadmin_role_id) {?>
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label class="control-label required">Reporting Manager:</label>
									<?= $form->field($model, 'reporting_user_id')->textInput(['maxlength' => true, 'value' => $reporting_user_name['first_name'],'readonly' => true])->label(false); ?>
								</div>
							<?php } ?>

						</div>
						<div class="hr"></div>

						<div class="col-md-12 text-center">
							<?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'userupdate', 'id' => 'user-editsubmit']) ?>
							<a href=" " type="button" class="btn btn-danger">Cancel</a>
						</div>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Popup End -->

	<!-- Modal Popup ORG -->


	<div class="modal fade" id="myModalOrg" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="panel-body panel-bg">
						<?php $form = ActiveForm::begin(); ?>
						<div class="form row col-md-12 mt20">

							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label class="control-label required">Company Name:</label>
								<?= $form->field($organization_model, 'organization_name')->textInput(['maxlength' => true, 'value' => $organization_details['organization_name']])->label(false); ?>
							</div>
							<div class="form-group col-xs-12 col-sm-6 col-md-6">
								<label class="control-label required">Company Email ID:</label>
								<?= $form->field($organization_model, 'contact_email')->textInput(['maxlength' => true, 'value' => $organization_details['contact_email'], 'readonly' => true])->label(false); ?>
							</div>
							<!-- <div class="form row col-md-12"> -->
								<div class="form-group col-xs-12 col-sm-6 col-md-6">
									<label class="control-label required">Phone No:</label>
									<?= $form->field($organization_model, 'phone_number')->textInput(['maxlength' => true, 'value' => $organization_details['phone_number']])->label(false); ?>
								</div>
							<!-- </div> -->
						</div>


						<div class="hr"></div>

						<div class="col-md-12 text-center">
							<?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'save', 'value' => 'orgprofileupdate', 'id' => 'company-editsubmit']) ?>
							<a href=" " type="button" class="btn btn-danger">Cancel</a>
						</div>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Popup End -->
	<?php
	$url = Url::home();
	$url = $url.'/users/ajaxphone/';
	$script = <<< JS
jQuery(document).ready(function($){
	//users delete
	$('#result5').attr('href','');
	$('#del_id').live('click',function(){
		var url = $(this).attr('delete_id');
		$('#result5').attr('href',url);
	});
	result = false;
//for user profile edit
	$('#user-editsubmit').click(function(){
		var phone_number = $('#users-phone_number').val();
		if (phone_number == '') {
			$('.field-users-phone_number').removeClass('has-success');
			$('.field-users-phone_number').addClass('has-error');
			$('div.field-users-phone_number').find('div').html('Phone Number cannot be blank.');
			return false;
		}
		if ((phone_number != '' && phone_number.length != 10 || phone_number.length > 12) && phone_number.length == 11) {
			$('.field-users-phone_number').removeClass('has-success');
			$('.field-users-phone_number').addClass('has-error');
			$('div.field-users-phone_number').find('div').html('Phone Number format is wrong.');
			return false;
		} else {
			$.ajax({
				url: '$url',
				data:{phone_number:phone_number},
				type:'post',
				async:false,
				success: function(data){
						if (data == 'exist') {
							$('.field-users-phone_number').removeClass('has-success');
							$('.field-users-phone_number').addClass('has-error');
							$('div.field-users-phone_number').find('div').html('Mobile No. already exist.');
							result = false;
						} else {
						    $('.field-users-phone_number').removeClass('has-error');
							$('.field-users-phone_number').addClass('has-success');
							$('.field-users-phone_number').find('help-block').html('');
							result = true;
						}
			}});
		return result;
		}
	});
//for company profile edit
	$('#company-editsubmit').click(function(){
		var phone_number = $('#inputcompanies-phone_number').val();
		if (phone_number == '') {
			$('.field-inputcompanies-phone_number').removeClass('has-success');
			$('.field-inputcompanies-phone_number').addClass('has-error');
			$('div.field-inputcompanies-phone_number').find('div').html('Mobile No cannot be blank.');
			return false;
		}
		if ((phone_number != '' && phone_number.length != 10 || phone_number.length > 12) && phone_number.length == 11) {
			$('.field-inputcompanies-phone_number').removeClass('has-success');
			$('.field-inputcompanies-phone_number').addClass('has-error');
			$('div.field-inputcompanies-phone_number').find('div').html('Mobile No format is wrong.');
			return false;
		} else {
			$.ajax({
				url: '$url',
				data:{phone_number:phone_number},
				type:'post',
				async:false,
				success: function(data){
						if (data == 'exist') {
							$('.field-inputcompanies-phone_number').removeClass('has-success');
							$('.field-inputcompanies-phone_number').addClass('has-error');
							$('div.field-inputcompanies-phone_number').find('div').html('Mobile No. already exist.');
							result = false;
						} else {
						    $('.field-inputcompanies-phone_number').removeClass('has-error');
							$('.field-inputcompanies-phone_number').addClass('has-success');
							$('.field-inputcompanies-phone_number').find('help-block').html('');
							result = true;
						}
			}});
		return result;	
		}
	});
		$('#users-bulkfile').on('change', function(){
		var bulk_upload_file_name = $(this).val();
		$('#inputuser-bulkfilename').text(bulk_upload_file_name);
		});
});
JS;
$this->registerJs($script);
?>