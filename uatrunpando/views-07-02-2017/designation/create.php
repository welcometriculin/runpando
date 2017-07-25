<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Designations */

$this->title = Yii::t('app', 'Create Designations');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Designations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designations-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
