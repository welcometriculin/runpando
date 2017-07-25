<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use app\models\ChannelPartners;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\View;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\ChannelPartnersSearch */
/* @var $form yii\widgets\ActiveForm */
$partners_list = ChannelPartners::channelPartnersList();
$months = ChannelPartners::currentYearMonthsList();
//$listData = array();
//$listData[0] = 'All'; 
//$listData = ArrayHelper::map($ProductList, 'id', 'product_name');
//$PartList = ArrayHelper::map($partners_list, 'channel_partner_name', 'channel_partner_name');
//asort($PartList);

?>

<div class="channel-partners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
    ]); ?>
	<div class="col-sm-4 col-md-3">
<?php 
					echo $form->field($model, 'channel_partner_name',['template' => "{label}\n<div class=''>{input}</div>\n{hint}\n{error}"])->widget(Select2::classname(), [
				    'data' => $PartnersInfo,
					'size' => Select2::MEDIUM,
				    'options' => ['class' => 'form-control'],
					'pluginOptions' => [
					'allowClear' => false,
					'tags' => false,
					//'templateResult' => new JsExpression('format'),
					//'templateSelection' => new JsExpression('format'),
					//'escapeMarkup' => $escape,
					//'maximumSelectionLength'=> 1
					],
				])->label('Your '. (count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner'),['class'=>'control-label']); ?>	</div>
	<div class="col-sm-4 col-md-3">
		<?= $form->field($model, 'product')->dropDownList($ProductList,['prompt' => 'All']); ?>	
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
					$(".table-responsive-dummy").html(str); 
					}else{
					  $(".table-responsive-dummy").html('<h4>No results found<h4>'); 
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