<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FormBuilder */

$this->title = 'Dynamic Form';
//$this->params['breadcrumbs'][] = ['label' => 'Form Builder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
if(Yii::$app->session->hasFlash('minimum2')) { 
?>
	<div class="alert alert-danger">
		<?php echo Yii::$app->session->getFlash('minimum2');  ?>
		</div>
<?php } else if(Yii::$app->session->hasFlash('minimum')) { ?>
	<div class="alert alert-danger">
			<?php echo Yii::$app->session->getFlash('minimum');  ?>
			</div>
<?php } ?>
	
<div class="form-builder-create">
    <?= $this->render('_form', [
        'model' => $model,
    	'label_names' => $label_names,
    	'companyList' => $companyList,
    ]) ?>

</div>
