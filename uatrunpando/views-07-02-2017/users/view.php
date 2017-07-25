<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Roles;
use app\models\Users;
use app\models\Designations;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'User Details';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
$ffofficer_role_id = Roles::FIELDFORCE;
?>
<div class="users-view">

   <?php $reporting_user_name = Users::getReportingUserName($model->id);?>
    <?php $designation_name = Designations::designationName($model->designation_id);?>

		<div class="panel-body panel-bg">
								<h3 class="panel-title">Details</h3>
									<div class="form  row mt20 label_frm">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left">
							<div class="form-horizontal" role="form">
							  <div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Name:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucwords($model->first_name.' '.$model->last_name) ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-label">State:</label>
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->state == ''?'N/A':ucfirst($model->state); ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-label">District:</label>
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->district == ''?'N/A':ucfirst($model->district); ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-label">Head Quarters:</label>
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->head_quarters == ''?'N/A':ucfirst($model->head_quarters); ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-label">Area of Operation:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->area_of_operatoin == ''?'N/A':ucfirst($model->area_of_operatoin); ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Email ID:</label>
								<label  class="col-xs-6  col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->email_address ?></label>
								</div>
								</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12  pull-right">
							<div class="form-horizontal" role="form">
							  <div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Phone No.:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->phone_number ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Role:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucwords($model->role->role_name) ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Designation:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $designation_name == ''?'N/A':ucfirst($designation_name); ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Reporting to:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucwords($reporting_user_name['first_name'].' '.$reporting_user_name['last_name']) ?></label>
								</div>
								<?php if ($model->role->id == $ffofficer_role_id && $model->photo != '') { ?>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Image:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= Html::img(Yii::getAlias('@imageurl').'/'.$model->photo_path.$model->photo, ['width'=>'100', 'height' => '100', 'alt' => 'Image']);?></label>
								</div>
								<?php } ?>
								</div>
								</div>
								</div>
											
					    </div>
</div>