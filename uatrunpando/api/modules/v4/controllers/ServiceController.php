<?php
namespace app\api\modules\v4\controllers;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
//use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\db\Query;
use yii;
use yii\web\UnauthorizedHttpException;
use yii\db\Expression;
use app\api\modules\v4\models\MobileTimeChange;


class ServiceController extends ActiveController
{

	public function actionMobiletime($automatic_time_zone,$automatic_date_time,$mobileTimeStamp,$params,$service_name,$mode)
	 {
		$userId = Yii::$app->user->identity->id;
		if($automatic_time_zone == 0 && $automatic_date_time == 1) {
			$time_zone = 'indias';
			if($time_zone != 'india') {
				$this->mailSend($params,$service_name,$userId,$mobileTimeStamp,$mode);
			}
		} else if(($automatic_time_zone == 1 && $automatic_date_time == 0)) {
			$currenthourTime = date('H');
			$mobileTimes = strtotime($mobileTimeStamp);
			$mobilehourTime =  date('H', $mobileTimes);
			$timedif = abs($mobilehourTime - $currenthourTime);
				if($timedif > 2) {
					$this->mailSend($params,$service_name,$userId,$mobileTimeStamp,$mode);
				}
			} else if(($automatic_time_zone == 0 && $automatic_date_time == 0)) {
				$currenthourTime = date('H');
				$mobileTimes = strtotime($mobileTimeStamp);
				$mobilehourTime =  date('H', $mobileTimes);
				$timedif = abs($mobilehourTime - $currenthourTime);
				$time_zone = 'indias';
				if($time_zone != 'india' && $timedif > 2) {
					$this->mailSend($params,$service_name,$userId,$mobileTimeStamp,$mode);
				}
			}
	} 
	function mailSend($params,$service_name,$userId,$mobileTimeStamp,$mode)
	 {
	 	$time_model = new MobileTimeChange();
	 	$time_model->user_id = $userId;
	 	$time_model->service_name = $service_name;
	 	$time_model->service_data = json_encode($params);
	 	$time_model->mode = $mode;
	 	$time_model->mobile_time = date("Y-m-d H:i:s", $mobileTimeStamp/1000);
	 	if($time_model->save(false)) {
		 	$template = $service_name;
		 	$mail = Yii::$app->smtpmail;
		 	$mail->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
		 	$mail->addAddress('sai.kuncha@raybiztech.com');
		 	$mail->CharSet = 'UTF-8';
		 	$mail->Subject = $service_name;
		 	$mail->MsgHTML($template);
		 	$mail->Send();
	 	}
	 }
}