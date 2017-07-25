<?php
use yii\widgets\ActiveForm;
$this->title = 'Bulk Upload Users';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="padding-top:50px">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="form-group">
    <?= $form->field($model, 'bulkfile')->fileInput(['class' => 'filestyle','data-input' => false]); ?>
	</div>
    <button>Submit</button>
    
    <div><?php echo $message;?></div>

<?php ActiveForm::end() ?>
      <?php 
$script = <<< JS
$(":file").filestyle({input: false});
JS;
$this->registerJs($script);
?>
