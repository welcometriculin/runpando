<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DesignationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Designations');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
	if (Yii::$app->session->hasFlash('designation-create')) {?>
	        <div class="alert alert-success">
	        Designation has been created successfully
        	</div>
	<?php 
	} elseif (Yii::$app->session->hasFlash('designation-update')) {?>
	        <div class="alert alert-success">
	        Designation has been updated successfully
        	</div>
	<?php 
	} elseif (Yii::$app->session->hasFlash('designation-delete')) { ?>
	        <div class="alert alert-success">
	        Designation has been deleted successfully
        	</div>
        	<?php } elseif (Yii::$app->session->hasFlash('designation-restrict')) { ?>
	        <div class="alert alert-danger">
	         Designation can not be deleted,since it has dependency.
        	</div>
        	<?php } ?>
<div class="designations-index">
	<div class="col-sm-12">
	<div class="row">
		<div class="pull-right">
		<a href="<?php echo Url::to(['create']);?>" type='button'
			class='btn btn-primary mb20'><i class='fa fa-plus'></i> Add New</a>
	</div>
	</div>
		<div class="row">
			<div class="table-responsive">
				<?php Pjax::begin(); ?>
				<?= GridView::widget([
						'dataProvider' => $dataProvider,
						//'filterModel' => $searchModel,
						'pager' => [
								'firstPageLabel' => 'First',
								'lastPageLabel' => 'Last',
						],
						'columns' => [
								//['class' => 'yii\grid\SerialColumn'],
								[
								'attribute' => 'designation_name',
								'enableSorting' => false,
								],
								['class' => 'yii\grid\ActionColumn', 'visible' => ($actioncolumns != '')? true:false,
								'header'=>'Action',
								'template'=> '{'.$actioncolumns.'}',
								'buttons'=>[
												'update' => function ($url, $data) {
												$url = Url::to(['designation/update/'.$data['guid']]);
												$dis = '<span class="fa fa-pencil-square-o" disabled></span>';
												return Html::a('<span class="fa fa-pencil-square-o"></span>', $url, [
														'title' => Yii::t('yii', 'Update'),
												]);
												},
												'delete' => function ($url, $data) {
												$url = Url::to(['designation/delete/'.$data['guid']]);
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
										],
    ]); ?>
				<?php Pjax::end(); ?>
			</div>
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
					<p>Are you sure you want to Delete Designation ?</p>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" type="button" class="btn btn-primary"
						id="result5">Yes</a> <a type="button" class="btn btn-danger"
						data-dismiss="modal">Cancel</a>
				</div>
			</div>
		</div>
	</div>
	 <?php 

$script = <<< JS

$(document).ready(function(){
	var url = '';
	$('#del_id').live('click',function(){
		var url = $(this).attr('delete_id');
		$('#result5').attr('href', url);
	});
		$('#crops-bulkcrops').on('change', function(){
		var bulk_upload_file_name = $(this).val();
		$('#inputuser-bulkfilename').text(bulk_upload_file_name);
		setTimeout(function(){
		$('#inputuser-bulkfileerror').hide();
	}, 5000);
	
});
});
JS;
$this->registerJs($script);
?>
	