<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use app\models\ChannelPartners;
/* @var $this yii\web\View */
/* @var $model app\models\ChannelPartnersSearch */
/* @var $form yii\widgets\ActiveForm */
$partners_list = ChannelPartners::channelPartnersList();
$months = ChannelPartners::currentYearMonthsList();
?>

<div class="channel-partners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
	<div class="col-sm-4 col-md-3">
			<?= $form->field($model, 'channel_partner_name')->dropDownList(ArrayHelper::map($partners_list, 'channel_partner_name', 'channel_partner_name'), ['prompt' => 'All'])->label('Your Partner') ?>
	</div>
	<div class="col-sm-4 col-md-3">
		<?= $form->field($model, 'status')->dropDownList(['product' => 'Product', 'collection' => 'Collection Status']) ?>	
	</div>
	<div class="col-sm-4 col-md-3">
		<?= $form->field($model, 'month')->dropDownList($months, ['prompt' => 'All']) ?>	
	</div>
    <?php //echo   $form->field($model, 'id') ?>

    <?php //echo  $form->field($model, 'guid') ?>

    <?php //echo $form->field($model, 'channel_partner_name') ?>

     <?php //echo $form->field($model, 'comp_id') ?>

     <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="clearfix"></div>
