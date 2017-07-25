<?php
namespace app\api\modules\v2\controllers;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii;
use app\models\Users;
class LoginController extends ActiveController
{
	public $modelClass = 'app\models\Users';
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
		return $res = Users::forGotpas($email);
	}

	public function actionSignup()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$res = Users::signUp($params);
		return $res;
	}
	
	
}