<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Designations */

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Designations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="designations-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
