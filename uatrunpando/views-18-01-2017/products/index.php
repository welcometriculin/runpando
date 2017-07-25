<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
	if (Yii::$app->session->hasFlash('products-create')) {?>
<div class="alert alert-success"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product') ?> added successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('products-update')) {?>
<div class="alert alert-success"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product') ?> Updated successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('products-delete')) {?>
<div class="alert alert-success"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product') ?> deleted successfully</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkproducts-success')) {?>
<div class="alert alert-success">
	<?php echo Yii::$app->session->getFlash('bulkproducts-success') ?>
</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkproducts-empty')) {
		?>
<div class="alert alert-danger">File is empty (or) All <?= (count($label_names_display) > 0 ? $label_names_display['product_label'] :'products') ?> are
	duplicate</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkproducts-fields-empty')) {
		?>
<div class="alert alert-danger">Fields are empty. Please fill.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkproducts-exist')) {
		?>
<div class="alert alert-danger">Already exist. Please check.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkproducts-wrong-file')) {
		?>
<div class="alert alert-danger">Wrong file format.</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('bulkproducts-duplicate-insert')) {
		?>
<div class="alert alert-danger">
	<?php echo Yii::$app->session->getFlash('bulkproducts-duplicate-insert') ?>
</div>
<?php 
	} elseif (Yii::$app->session->hasFlash('products-restrict')) {
	?>
		    <div class="alert alert-danger">
         <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'products') ?> can not be delete,since it has been dependency.
        	</div>
    <?php 
	} 
	?>
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
	<hr>
<div class="browse-form">
	<div class="row">
			<div class="bulkfile_main pull-left">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    	<div class="mr15 bulk-upload-mr0 pull-left float-none">
    		<?php /* ?><?= $form->field($model, 'bulkfile')->fileInput(['class'=>'file_btn form-control c-browse'])->label(false)  ; ?><?php */ ?>
    		<div class="bulk_upload_button">
    			<?= $form->field($model, 'bulkproducts', ['template' => '<div id = "label_bulkupload">{label}</div>{input}<div id="inputuser-bulkfilename" style="color: #7f64b5"></div>
    			
        	{hint}{error}', 'options' => ['tag' => 'div', 'class' => 'custom-upload-button'], 'labelOptions' => ['class' => 'custom-upload-label']])->fileInput(['class'=>'file_btn form-control c-browse'])->label('<i aria-hidden="true" class="fa fa-upload"></i> &nbsp Upload '.(count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products'))  ; ?>
    		</div>
    	</div>

    	<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'bulk','id'=>'bulk','value' => 'saved']) ?>

	<?php ActiveForm::end() ?>
	</div>
		<div class="pull-right bulkfile_temp clearfix btn_excel  btn_center">
			<div class="pull-left">
			<a href="<?php echo Url::to(['download']);?>" type="button"
				class="btn btn-primary mb20"><i class="fa fa-download"
				aria-hidden="true"></i> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Products') ?> Template</a> <div class="clearfix"></div><span>(Click here for
				<?= (count($label_names_display) > 0 ? $label_names_display['product_label'] :'products') ?> excel template)</span>
			</div>
			<div class="pull-right">
			<a href="<?php echo Url::to(['create']);?>" type='button'
						class='btn btn-primary mb20'><i class='fa fa-plus'></i> Add New</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>


<div class="products-index">
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="col-sm-12">
		<div class="row">
			<div class="table-responsive">
				<?= GridView::widget([
						'dataProvider' => $dataProvider,
						//'filterModel' => $searchModel,
						//'layout'=>"<div class='grid_show'>{summary} <div class='clearfix'></div></div>\n<div class='table-responsive'>{items}\n{pager}</div>",
						'pager' => [
								'firstPageLabel' => 'First',
								'lastPageLabel' => 'Last',
						],
						'columns' => [
								[
										'attribute' => 'product_name',
										'label'=> (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'Product Name'),
										'enableSorting' => false,
										'value' => function($data) {
										return $data->product_name;
				}
				],


				['class' => 'yii\grid\ActionColumn', 'visible' => ($actioncolumns != '')? true:false,
						'header'=>'Action',
						'template'=> '{'.$actioncolumns.'}',
						'buttons'=>[
								'update' => function ($url, $data) {
								$url = Url::to(['products/update/'.$data['guid']]);
								$dis = '<span class="fa fa-pencil-square-o" disabled></span>';
								return Html::a('<span class="fa fa-pencil-square-o"></span>', $url, ['title' => Yii::t('yii', 'update')]);
				},
				'delete' => function ($url, $data) {
				$url = Url::to(['products/delete/'.$data['guid']]);
				return Html::a('<span class="fa fa-trash-o"></span>', '#', [
						'title' => Yii::t('yii', 'delete'),
						'id' => 'del_id',
						'delete_id' => $url,
						'data-toggle' => 'modal',
						'data-target' => '#myModal'
				]);
				}
				]
				],

				],
    ]); ?>
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
					<p>Are you sure you want to Delete <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['product_label']) :'product')?>?</p>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" type="button" class="btn btn-primary"
						id="result5">Okay</a> <a type="button" class="btn btn-danger"
						data-dismiss="modal">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$script = <<< JS
$(document).ready(function(){
	$('#del_id').live('click',function(){
		var url = $(this).attr('delete_id');
		$('#result5').attr('href', url);
	});
		$('#products-bulkproducts').on('change', function(){
		var bulk_upload_file_name = $(this).val();
		$('#inputuser-bulkfilename').text(bulk_upload_file_name);
		});
});
JS;
$this->registerJs($script);
?>
