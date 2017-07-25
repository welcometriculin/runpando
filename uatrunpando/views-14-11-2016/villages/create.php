<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Villages */

$this->title = 'Add New';
$this->params['breadcrumbs'][] = ['label' => (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Villages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="villages-create">
    <?= $this->render('_form', [
        'model' => $model,
    	'mmlist' => $mmlist,
    	'label_names_display' => $label_names_display,
    ]) ?>

</div>
