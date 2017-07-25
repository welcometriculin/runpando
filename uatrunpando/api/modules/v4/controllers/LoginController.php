<?php
namespace app\api\modules\v4\controllers;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii;
use app\api\modules\v4\models\Users;
use app\api\modules\v4\models\WebService;
class LoginController extends ActiveController
{
	public $modelClass = 'app\api\modules\v4\models\Users';
	public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items',
	];
	public function behaviors()
	{

		$behaviors = parent::behaviors();

		$behaviors['contentNegotiator'] = [
				'class' => ContentNegotiator::className(),
				'formats' => [
						'application/json' => Response::FORMAT_JSON,
						//'application/xml' => Response::FORMAT_XML,
				],
		];

		return $behaviors;
	}
	
	public function actions()
	{
		$actions = parent::actions();

		unset($actions['delete'],$actions['view'],$actions['index']);
		// customize the data provider preparation with the "prepareDataProvider()" method
		//$actions['login']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
		return $actions;
	}
	
	public function actionForgot()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$email = $params['email'];
		$web_model = new WebService();
		$web_model->user_id = Yii::$app->user->identity->id;
		$web_model->params = json_encode($params);
		$web_model->service_name = 'forgot';
		$web_model->save(false);
		return $res = Users::forGotpas($email);
	}

	public function actionSignup()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$web_model = new WebService();
		$web_model->user_id = Yii::$app->user->identity->id;
		$web_model->params = json_encode($params);
		$web_model->service_name = 'sign_up';
		$web_model->save(false);
		$res = Users::signUp($params);
		return $res;
	}
	
	
}