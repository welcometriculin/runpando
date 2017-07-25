<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\InputCompanies */

$this->title = 'Organization Details';
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="input-companies-view">

    <!-- <h1><?/*= Html::encode($this->title)*/ ?></h1> -->
<?php $employee_id = \app\models\Users::getEmployeeID($model->id);?>
    <p>
    <?php $url = Url::home();?>
        
    </p>

								<h3 class="panel-title">Details</h3>
									<div class="form  mt20 label_frm">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-left">
							<div class="form-horizontal" role="form">
							  <div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Organization Name:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucwords($model->organization_name) ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Person Name:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->person_name ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Email ID:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->contact_email ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Employee ID:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $employee_id['employee_number'] ?></label>
								</div>
								</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right">
							<div class="form-horizontal" role="form">
							  <div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Phone No.:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->phone_number ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Paid Amount:</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= ucfirst($model->paid_amount) ?></label>
								</div>
								<div class="form-group">
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-label">Number of Apps Users :</label>
								<label  class="col-xs-6 col-sm-6 col-md-6 col-lg-6 control-input"><?= $model->number_of_licences?></label>
								</div>
								</div>
								</div>
								</div>
			

</div>
<?php 
$script = <<< JS
$(document).ready(function(){
	$('#modalButton').click(function(){
	$('#modal').modal('show')
		   .find('#modalContent')
		   .load($(this).attr('value'));
	});
});
JS;
$this->registerJs($script);
?>
