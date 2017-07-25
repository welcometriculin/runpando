<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use app\models\ChannelPartners;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\ChannelPartnersSearch */
/* @var $form yii\widgets\ActiveForm */
$partners_list = ChannelPartners::channelPartnersList();
$months = ChannelPartners::currentYearMonthsList();
$listData = array();
$listData[0] = 'All'; 
$listData = ArrayHelper::map($ProductList, 'id', 'product_name');
$PartList = ArrayHelper::map($partners_list, 'channel_partner_name', 'channel_partner_name');
asort($PartList);

?>

<div class="channel-partners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
    ]); ?>
	<div class="col-sm-4 col-md-3">
			<?= $form->field($model, 'channel_partner_name')->dropDownList($PartList)->label('Your Partner') ?>
	</div>
	<div class="col-sm-4 col-md-3">
		<?= $form->field($model, 'product')->dropDownList($listData,['prompt' => 'All']); ?>	
	</div>
	<div class="col-sm-4 col-md-3">
	</div>
    <?php ActiveForm::end(); ?>
       <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary','id' => 'channelpartners']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

</div>
<div class="clearfix"></div>
	<?php
$url = Url::home();
$list_url = $url.'/channelpartners/ajaxdata';
$script = <<< JS

 var channel_partner = $('#channelpartners-channel_partner_name').val();
 var product = $('#channelpartners-product').val();
 ajaxpartners(channel_partner,product);
function ajaxpartners(channel_partner,product) {
			$.ajax({
			 	type: 'post',
			 	url:'$list_url',
				data:{channel_partner:channel_partner,product:product},
				success: function(response){
				var str = '';
					 res = eval(response);
					if(res.length > 0){   
					   	for(i = 0; i < res.length;i++) {
							str += res[i];
						}
					$(".table-responsive").html(str); 
					}else{
					  $(".table-responsive").html('<h4>No results found<h4>'); 
					}
		
				
				}
			});
}
$("#channelpartners").click(function(){
		 var channel_partner = $('#channelpartners-channel_partner_name').val();
 var product = $('#channelpartners-product').val();
			ajaxpartners(channel_partner,product);
		});
		
JS;
$this->registerJs($script);
?>