<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\TravelLog;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\TravelLog */

$this->title = 'Travel Details';
$this->params['breadcrumbs'][] = ['label' => 'Travel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$params = Yii::$app->request->queryParams;
$ff = TravelLog::travellogFfId($params['id']);
$date = $params['date'];
// echo $date['assign_to'].$date['updated_date'];
$village_names = \app\models\Travellog::villagenames($ff['assign_to'], $date);
$distance_travelled = \app\models\Travellog::distance_travelled($ff['assign_to'], $date);
$travellog_cardslist = \app\models\Travellog::travellog_cardslist($ff['assign_to'], $date);
$travellog_cardslist_info = $travellog_cardslist[0];
?>
<div class="travel-details">

<div class="panel-body panel-bg">
<div id="map-container" class="" style="position: relative; background-color: rgb(229, 227, 223); overflow: hidden;">
    </div>
    </div>
	<div class="panel-body panel-bg travel-details">
	<div class="form-horizontal travel-block clearfix">

			<div class="col-sm-4">
				<div class="form-group"> 
					<label class="control-label">Distance:</label> <label
						class="control-input"><?= substr($distance_travelled_sum, 0 ,strpos($distance_travelled_sum, '.')+4). ' kms'?>
					</label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<div class="text-center">
					<label class="control-label">Plans:</label> <label
						class="control-input"><?= ($travellog_cardslist_info['number_of_cards']) ? $travellog_cardslist_info['number_of_cards'] : 0 ?>
					</label>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<div class="text-right">
					<label class="control-input"><?= date('D d M', strtotime($date))?>
					</label>
					</div>
				</div>
			</div>
	
		</div>
		<div class="row">
		<div class="col-md-12">
		<div class="table-responsive">
<?php Pjax::begin([ 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']])  ?>
		<?= GridView::widget([
        'dataProvider' => $dataProvider,
				'pager' => [
						'firstPageLabel' => 'First',
						'lastPageLabel' => 'Last',
				],
        //'filterModel' => $searchModel,
    	'summary'=>'',
    	'showHeader' => true,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			[
			'label'=> 'Activity',
			'format'=>'raw',
			'enableSorting' => false,
			'value' => function ($data) {
				if ($data['activity'] == 'Farm and Home Visit') {
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/fhv.png',['alt' => $data['activity'],'title'=>$data ['activity']]).'</div>';
				} elseif ($data['activity'] == 'Farmer Group Meeting') {
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/fgm.png',['alt' => $data['activity'],'title'=>$data ['activity'] ]).'</div>';
				} elseif ($data['activity'] == 'Mass Campaign') {
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/mass-campaign.png',['alt' => $data['activity'],'title'=>$data ['activity']]).'</div>';
				} elseif ($data['activity'] == 'Demonstration') {
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/demo.png',['alt' => $data['activity'],'title'=>$data ['activity']]).'</div>';
				} elseif ($data['activity'] == 'start'){
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/start-mdpi.png',['alt' => $data['activity'],'title'=>ucfirst($data ['activity'])]).'</div>';
				} elseif ($data['activity'] == 'stop'){
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/stop-mdpi.png',['alt' => $data['activity'],'title'=>ucfirst($data ['activity'])]).'</div>';
				}  elseif ($data['activity'] == 'Channel Card'){
					$data['activity'] = 'Partner Visit';
					return '<div class="img-wd">'.Html::img(Url::home().'/../img/channel-partner1.png',['alt' => $data['activity'],'title'=>$data ['activity']]).'</div>';
				} 
			}
			],
    		[
    		'attribute' => 'location_name',
    		'label'=> 'Location',
    		'format'=>'raw',
    		'enableSorting' => false,
    		'value' => function ($data) {
    		return Html::tag('span', Html::encode(ucfirst($data['location_name'])), ['class' => 'village']);    			 
    		}
    		],
    		/*  [
    		'attribute' => 'updated_date',
    		'label'=> false,
    		'format'=>'raw',
    		'enableSorting' => false,
    		'value'=> function ($data) {
    		$date = date('h:i a', strtotime($data['start_time'])). ' - ' .date('h:i a', strtotime($data['end_time']));
    		return Html::tag('span', $date, ['class' => '']);
    		}
    		],  */
    		[
    				'attribute' => 'updated_date',
    				'label'=> 'Submission Time',
    				'format'=>'raw',
    				'enableSorting' => false,
    				'value'=> function ($data) {
    				//$date = date('h:i a', strtotime($data['start_time'])). ' - ' .date('h:i a', strtotime($data['end_time']));
 			return Html::tag('span', date('h:i a', strtotime($data['end_time'])), ['class' => '']);
    								}
    		],
    		[
    		'attribute' => 'mode',
    		'label'=> 'Mode',
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return Html::tag('span', ucfirst($data['mode']), ['class' => ($data['mode']=='offline') ? 'adhoc' : 'planned']);
    		    }
    		   ],
    		[
    		'attribute' => 'distance_travelled',
    		'label'=> 'Distance',
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return substr($data['distance_travelled'], 0 ,strpos($data['distance_travelled'], '.')+4). ' kms';
    		}
    		],
    		[
    		'attribute' => 'time',
    		'label'=> 'Spent Time (Hours)',
    		'enableSorting' => false,
    		'format'=> 'raw',
    		'value'=> function ($data) {
    		return round($data['time'],2);
    		    		}
    		],
            //'id',
            //'guid',
            //'assign_to',
            //'card_type',
            //'planned_date',
            // 'plan_type',
            // 'crop_name',
            // 'product_name',
            // 'channel_partner',
            // 'village_name',
            // 'activity',
            // 'distance_travelled',
            // 'status',
            // 'plan_approval_status',
            // 'created_date',
            // 'created_by',
            // 'updated_date',
            // 'updated_by',
            // 'is_deleted',

    		//['class' => 'yii\grid\ActionColumn'],
    		],
    ]); ?>
     <?php Pjax::end(); ?>
    </div>
    </div>
    <div class="cleaarfix"></div>
    </div>
	<!-- 	<div class="row">
			<div class="col-sm-4 form-inline userlist mt20">
				<label>Display</label> <select class="form-control">
					<option>10</option>
					<option>20</option>
					<option>30</option>
					<option>All</option>
				</select> <label>per Page</label>
			</div>
		</div> -->
	</div>
	<?php $this->registerJsFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyA7IZt-36CgqSGDFK8pChUdQXFyKIhpMBY&sensor=true',['depends' => [\yii\web\JqueryAsset::className()]]); ?>
<?php 
$script = <<< JS
		var map;
        var geocoder;
        var marker;
        var people = new Array();
        var latlng;
        var infowindow;

        jQuery(document).ready(function($){
            ViewCustInGoogleMap();
        });

        function ViewCustInGoogleMap() 
        {
			var data = '$village_names';
			people = JSON.parse(data); 
			var lat = people[0].lat_position;
		    var long = people[0].long_position;
			var mapOptions = {
                center: new google.maps.LatLng(lat,long),   // Coimbatore = (11.0168445, 76.9558321)
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-container"), mapOptions);

            // Get data from database. It should be like below format or you can alter it.
            for (var i = 0; i < people.length; i++) {
                setMarker(people[i]);
            }
        }

        function setMarker(people) 
        {
            geocoder = new google.maps.Geocoder();
            infowindow = new google.maps.InfoWindow();
            if ((people["LatitudeLongitude"] == null) || (people["LatitudeLongitude"] == 'null') || (people["LatitudeLongitude"] == '')) {
                geocoder.geocode({ 'address': people["Address"] }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                        marker = new google.maps.Marker({
                            position: latlng,
                            map: map,
                            draggable: false,
                            html: people["DisplayText"],
                            icon: "images/marker/" + people["MarkerId"] + ".png"
                        });
                        //marker.setPosition(latlng);
                        //map.setCenter(latlng);
                        google.maps.event.addListener(marker, 'click', function(event) {
                            infowindow.setContent(this.html);
                            infowindow.setPosition(event.latLng);
                            infowindow.open(map, this);
                        });
                    }
                    else {
                        //alert(people["DisplayText"] + " -- " + people["Address"] + ". This address couldn't be found");
                    }
                });
            }
            else {
                var latlngStr = people["LatitudeLongitude"].split(",");
                var lat = parseFloat(latlngStr[0]);
                var lng = parseFloat(latlngStr[1]);
                latlng = new google.maps.LatLng(lat, lng);
                marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    draggable: false,               // cant drag it
                    html: people["DisplayText"]    // Content display on marker click
                    //icon: "images/marker.png"       // Give ur own image
                });
                //marker.setPosition(latlng);
                //map.setCenter(latlng);
                google.maps.event.addListener(marker, 'click', function(event) {
                    infowindow.setContent(this.html);
                    infowindow.setPosition(event.latLng);
                    infowindow.open(map, this);
                });
            }
        }
JS;
$this->registerJs($script);
?>