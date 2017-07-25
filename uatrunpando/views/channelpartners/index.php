<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ChannelPartnersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-partners-index">
	<?php  echo $this->render('_search', ['model'=> $searchModel]); ?>
	<div class="table-responsive">
	<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'pager' => [
					'firstPageLabel' => 'First',
					'lastPageLabel' => 'Last',
			],
			// 'filterModel' => $searchModel,
			'columns' => $columns,
    ]); ?>
</div>
</div>
