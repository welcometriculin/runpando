<?php
use yii\helpers\Url; ?>
<h3 style="text-align: center">Your Session has Expired. Please <a href ="<?php echo Url::to(['site/login'])?>" >Login</a> again</h3>

     <?php 
$script = <<< JS

$('#navhead').hide();
$('.footer').hide();		

JS;
$this->registerJs($script);
?>