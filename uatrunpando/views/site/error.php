<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

/* $this->title = $name; */
$this->title = 'Error';
$this->params['breadcrumbs'][] = $this->title;
$loginsession =\Yii::$app->session->get('loginid');
?>
<!-- <div class="site-error">



    <div class="alert alert-danger">
        <?/*= nl2br(Html::encode($message))*/ ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>
    <p style=<?php /*if ($loginsession == '') { echo "padding-top:90px"; } else { }?>>
		<?= Html::img('@imageurl/img/broke.png', ['class' => 'pull-left img-responsive']);*/ ?>
	</p>
</div>-->
 <!-- <div class="home pull-right"><a href="<?php //echo Url::home(); ?>"><i class="glyphicon glyphicon-home"></i></a></div> -->
        <!-- Top content -->
<?php 
$class = '';
if ($loginsession == '') {
	$class = 'beforelogin_broke';
}?>
<div class="top-content">
	<div class="inner-bg">
		<div class="">
				<div class="col-sm-6 col-sm-offset-3 form-box  broke-box <?php echo $class;?>">
					<div class="broke-form text-center">
						<div class="">
							<h3>Oops! Something went wrong.</h3>
						</div>
					</div>
					<div class="broke-form">
						<b class = "error-message">Please Contact Administrator</b>
					</div>
				</div>
			</div>
	</div>
</div>
<?php 
$script = <<< JS
	$('.beforelogin_broke').parents('body').addClass('login_broke-ftr');

JS;
$this->registerJs($script);
?>
