<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\LabelNames;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChannelPartnersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['partner_label']) :'Partner Name');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-partners-index">
	<?php  echo $this->render('_search2', ['model'=> $model,'ProductList' => $ProductList,'PartnersInfo' =>$PartnersInfo,'label_names_display' => $label_names_display]); ?>
	<div class="table-responsive-dummy">
	
</div>
</div>
