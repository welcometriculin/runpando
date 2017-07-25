<?php
namespace app\api\modules\v2\models;

use Yii;
use yii\base\Model;
use app\models\PlanCards;

/**
 * LoginForm is the model behind the login form.
 */
class CardSubmit extends Model
{
	public static function dataSubmit($activity)
	{
		return $activity;
	}
	public static function synCards($cards)
	{
		foreach($cards as $card)
		{
			$model=new PlanCards;
			$model->attributes=$card;
			if(!$model->save(false))
				return 'not saved';
		}
		return 'created';
	}

	public static function versionUpdate()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$service_uri = $_SERVER['REQUEST_URI'];
		$service_uri_arr = explode('/',$service_uri);
		if(in_array('syncdb',$service_uri_arr) || in_array('complete',$service_uri_arr) || in_array('submit',$service_uri_arr) || in_array('channel',$service_uri_arr)) {
			if(!array_key_exists('offline',$params) && empty($params['offline'])) {
				echo json_encode(['message' => 'Application update is required', 'status' => true, 'status_code' => '201']);exit;
			} else {
				//
			}
		} else {
			echo json_encode(['message' => 'Application update is required', 'status' => true, 'status_code' => '201']);exit;
		}
	
	}
	
}