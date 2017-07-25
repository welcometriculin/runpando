<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ChannelPartners */

$this->title = 'Add New';
$this->params['breadcrumbs'][] = ['label' => 'Partners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-partners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
