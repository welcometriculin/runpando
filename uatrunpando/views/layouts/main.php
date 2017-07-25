<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
$loginsession = Yii::$app->session;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?= Yii::getAlias('@weburl'); ?>/img/favicon.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode('Runpando') ?></title>
    <?php $this->head() ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <?php //include('google_analytics.php');?>
</head>
<?php 
$bodyClass = 'index';
$controller = strtolower(Yii::$app->controller->id);
$action = strtolower(Yii::$app->controller->action->id);
$dashboardClass = '';
$performanceClass='';
$content_body='content-body';
$panel_body='panel-body panel-bg';
if(!empty($loginsession['loginid']) && $controller !="dashboard") {	
	$bodyClass = 'bg';
} elseif (!empty($loginsession['loginid']) && $controller ="dashboard") {
	$bodyClass = 'bg-grad';
}
if (($controller == 'site' && ($action == 'login' || $action == 'forgotpassword'))) {
	$bodyClass = 'login-bg';
}
if(empty($loginsession['loginid']) && ($controller ="inputcompanies" && $action == 'create')) {
	$bodyClass = 'login-bg';
}
if ($controller == 'dashboard') {
	$dashboardClass = 'dashboard';
	$performanceClass ='performance';
	$content_body='';
	$panel_body = '';
}
?>
<body class='<?php echo $bodyClass; ?>'>
<div id="loader-image" style="display:none;">
</div>
<div id="page-top" >
<?php $this->beginBody() ?>
<?php if($loginsession['loginid']=='')
   	{	
   		include('login-header.php');
   	}else{
   		include('dash-header.php');
   	}?>

 <?php if($loginsession['loginid']==''){ ?>
	
        <?= $content ?>
      
	<?php }else{?>
   
   <div id="content" class="clearfix min-cont <?php echo  $dashboardClass?>">
   
							  <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
							
       <div class="col-sm-12 con-bg <?php echo  $performanceClass?>">
       <?php if (Yii::$app->controller->action->id != 'profile') {?>
      <h1 class="ellipsis-txt"><?= Html::encode($this->title) ?></h1>
       <div class="<?php echo  $content_body?>">
	   <div class="<?php echo  $panel_body?>">
        <?= $content ?>
        </div>
        </div>
        <?php } else {?>
        <?= $content ?>
        <?php }?>
        </div>
        </div>
        </div>
        </div>
    </div>
    <?php }?>

    
      <footer class = "footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <span class="copyright">Copyright &copy; Pando 2016</span>
                </div>
                <div class="col-md-4 col-sm-3">
                <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                              </div>
                <div class="col-md-4 col-sm-5">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
 
<?php $this->endBody() ?>
<?php
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$js = <<<JS
$(document).ready(function() {		
/*clicked tabs stay active start*/
	sessionStorage.tabClicked;
	if ("$controller" != 'formbuilder'){
		sessionStorage.removeItem('tabClicked');
	}
	$('.tabs li').click(function(){
		sessionStorage.tabClicked = $(this).prevAll().length;
	});
	if (sessionStorage['tabClicked']) {
		if (sessionStorage.tabClicked != '' && sessionStorage.tabClicked != 'undefined') {
			$('.tabs li:eq('+sessionStorage.tabClicked+')' ).find('a').click();
		}
	}
/*clicked tabs stay active end*/		
});   
JS;
$this->registerJs($js);
?>
</body>
<!--Author:Gowtham ->To disable mouse right click for security purpose script starts from here-->
<script language="javascript">
var message="This function is not allowed here.";
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}
function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}
if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}
document.oncontextmenu=new Function("alert(message);return false;")
</script>
<!--script ended here-->
<!--Author:gowtham -> To disable f12 key for security purpose script starts from here-->
<script>
    $(document).keydown(function(event){
    if(event.keyCode==123){
        alert("This function is not allowed here"); 
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){  
        
             return false;
    }
});

$(document).on("contextmenu",function(e){        
   e.preventDefault();
});
//script ends here..!
    </script>
</html>
<?php $this->endPage() ?>

