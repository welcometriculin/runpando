<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VillagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Villages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="villages-index clearfix">
	<?php 
	if(Yii::$app->session->hasFlash('villages-create')){?>
	<div class="alert alert-success"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> mapped successfully</div>
	<?php 
	}elseif(Yii::$app->session->hasFlash('villages-create-fail')) {?>
	<div class="alert alert-danger"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> not Created successfully</div>
	<?php } elseif(Yii::$app->session->hasFlash('villages-delete')) {?>
	<div class="alert alert-success"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> deleted successfully</div>
	<?php } elseif(Yii::$app->session->hasFlash('villages-delete-fail')) {?>
	<div class="alert alert-danger"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> not deleted</div>
	<?php }  elseif(Yii::$app->session->hasFlash('villages-plancard')) {?>
	<div class="alert alert-danger">This <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> have plancards.It can't
		delete.</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkvillages-wrong-file')) {?>
	<div class="alert alert-danger">You upload wrong file</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkvillages-fields-empty')) {?>
	<div class="alert alert-danger"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> names are empty</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkvillages-exist')) {?>
	<div class="alert alert-danger">
		<?php echo Yii::$app->session->getFlash('bulkvillages-exist') ?>
	</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkvillages-success')) {?>
	<div class="alert alert-success">
		<?php echo Yii::$app->session->getFlash('bulkvillages-success') ?>
	</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkvillages-empty')) { ?>
	<div class="alert alert-danger">village are empty</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkemail-not-exist')) { ?>
	<div class="alert alert-danger">
		<?php echo Yii::$app->session->getFlash('bulkemail-not-exist') ?>
	</div>
	<?php } elseif(Yii::$app->session->hasFlash('villages-update')) { ?>
	<div class="alert alert-success"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> updated successfully</div>
	<?php } elseif(Yii::$app->session->hasFlash('villages-update-fail')) { ?>
	<div class="alert alert-danger"><?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village')?> updated fail</div>
	<?php }elseif(Yii::$app->session->hasFlash('bulkvillages-empty-data')) { ?>
	<div class="alert alert-danger">No content available (or) duplicates
		available</div>
	<?php } elseif(Yii::$app->session->hasFlash('bulkemail-villages-exist')) { ?>
	<div class="alert alert-danger">
		<?php echo Yii::$app->session->getFlash('bulkemail-villages-exist') ?>
	</div>
	<?php }elseif(Yii::$app->session->hasFlash('bulkvillages-duplicate-insert')) { ?>
	<div class="alert alert-danger">
		<?php echo Yii::$app->session->getFlash('bulkvillages-duplicate-insert') ?>
	</div>
	<?php }?>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>


	<?php echo $this->render('_search', ['model' => $searchModel]); ?>

	<hr>
	<div class="browse-form">
		<div class="row">
			<div class="bulkfile_main pull-left">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    	<div class="mr15 bulk-upload-mr0 pull-left float-none">
    		<?php /* ?><?= $form->field($model, 'bulkfile')->fileInput(['class'=>'file_btn form-control c-browse'])->label(false)  ; ?><?php */ ?>
    		<div class="bulk_upload_button">
    			<?= $form->field($model, 'bulkvillages', ['template' => '<div id = "label_bulkupload">{label}</div>{input}<div id="inputuser-bulkfilename" style="color: #7f64b5"></div>
    			
        	{hint}{error}', 'options' => ['tag' => 'div', 'class' => 'custom-upload-button'], 'labelOptions' => ['class' => 'custom-upload-label']])->fileInput(['class'=>'file_btn form-control c-browse'])->label('<i aria-hidden="true" class="fa fa-upload"></i> &nbsp Upload '.(count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Villages'))  ; ?>
    		</div>
    	</div>

    	<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'bulk','id'=>'bulk','value' => 'saved']) ?>

	<?php ActiveForm::end() ?>
	</div>
			<div class="pull-right bulkfile_temp clearfix btn_excel">
			<div class="pull-left">
			<a href="<?php echo Url::to(['download']);?>" type="button"
				class="btn btn-primary mb20 ellipsis-txt"><i class="fa fa-download"
				aria-hidden="true"></i> <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Villages') ?> Template</a> <div class="clearfix"></div><span>(Click here for
				<?= (count($label_names_display) > 0 ? $label_names_display['village_label'] :'Villages') ?> excel template)</span>
			</div>
			<div class="pull-right">
			<a href="<?php echo Url::to(['create']);?>" type='button'
						class='btn btn-primary mb20'><i class='fa fa-plus'></i> Add New</a>
			</div>
			<div class="clearfix"></div>
		</div>
		</div>
	</div>
</div>


<div class="col-sm-12">
	<div class="row">
		<div class="table-responsive">

			<?= GridView::widget([
					'dataProvider' => $dataProvider,
					// 'filterModel' => $searchModel,
					/*'layout'=>"<div class='grid_show'>{summary} <a
					href='create' type='button'
					class='btn btn-primary mb20'><i class='fa fa-plus'></i> Add New</a><div class='clearfix'></div></div>\n<div class='table-responsive'>{items}\n{pager}</div>",*/

					'pager' => [
							'firstPageLabel' => 'First',
							'lastPageLabel' => 'Last',
					],
					'columns' => [

							[
									'attribute' => 'village_name',
									'label'=> (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village Name'),
									'enableSorting' => false,
									'value'=>function($data) {
									return $data['village_name'];
			}
			],

			[
					'attribute' => 'first_name',
					'label'=> 'Field Force Name',
					'enableSorting' => false,
					'value'=>function($data) {
					return ucfirst($data['first_name']);
			}
			],
			// 								'created_date',
			['class' => 'yii\grid\ActionColumn', 'visible' => ($actioncolumns != '')? true:false,
					'header'=>'Action',
					'template'=> '{'.$actioncolumns.'}',
					'buttons'=>[
							'update' => function ($url, $data) {
							$url = Url::to(['villages/update/'.$data['guid']]);
							$dis = '<span class="fa fa-pencil-square-o" disabled></span>';
							return Html::a('<span class="fa fa-pencil-square-o"></span>', $url, ['title' => Yii::t('yii', 'Update')]);
			},
			'delete' => function ($url, $data) {
			$url = Url::to(['villages/delete/'.$data['guid']]);
			return Html::a('<span class="fa fa-trash-o"></span>', '#', [
					'title' => Yii::t('yii', 'Delete'),
					'id' => 'del_id',
					'delete_id' => $url,
					'data-toggle' => 'modal',
					'data-target' => '#myModal'
			]);
			}
			]
			],
			// 'created_by',
			// 'created_date',
			// 'updated_by',
			// 'updated_date',

			/* ['class' => 'yii\grid\ActionColumn'], */
			],
    ]); ?>
		</div>

	</div>
	<!--  delete modal -->
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
					<p>Are you sure you want to Delete <?= (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village') ?>?</p>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" type="button" class="btn btn-primary"
						id="result5">Okay</a> <a type="button" class="btn btn-danger"
						data-dismiss="modal">Cancel</a>
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
		$('#villages-bulkvillages').on('change', function(){
		var bulk_upload_file_name = $(this).val();
		$('#inputuser-bulkfilename').text(bulk_upload_file_name);
		});
});
JS;
	$this->registerJs($script);
	?>