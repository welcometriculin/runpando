<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FormBuilder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-builder-form">

   
     <div class="panel-group form-accordion" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            <h4 class="panel-title">
                                       <span>   <i class="indicator fa fa-minus"></i> 
                                     STEP 1
                                    
                                       </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        
                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><h4 class="panel-title">  <span> <i class="indicator fa fa-plus"></i>
                                     STEP 2
                                       </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                           <form>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                     
                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">    <h4 class="panel-title">  <span>  <i class="indicator fa fa-plus"></i>
                                     STEP 3
                                      </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                              <form>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                     
                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">    <h4 class="panel-title">  <span>  <i class="indicator fa fa-plus"></i>
                                     STEP 4
                                      </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                              <form>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                            <h4 class="panel-title">
                                       <span>  
                                    STEP 5
                                       <i class="indicator fa fa-plus  pull-left"></i> </span>
                                    </h4></a>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <form>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <?= $form->field($model, 'form_builder_activity_id')->textInput() ?>

    <?= $form->field($model, 'step')->textInput() ?>

    <?= $form->field($model, 'required')->textInput() ?>

    <?= $form->field($model, 'mandatory')->textInput() ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'validation_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

 <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     

</div>
