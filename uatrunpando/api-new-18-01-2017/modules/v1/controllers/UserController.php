<?php
namespace app\api\modules\v1\controllers;

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
class UserController extends ActiveController
{
	
	public $modelClass = 'app\models\Users';
	public function behaviors()
	{
	
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
				'class' => CompositeAuth::className(),
				'authMethods' => [
						//HttpBasicAuth::className(),
						//HttpBearerAuth::className(),
						QueryParamAuth::className(),
				],
		];
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
	
		//unset($actions['login'],$actions['delete'],$actions['view']);
		// customize the data provider preparation with the "prepareDataProvider()" method
		//$actions['login']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
	
		
	
		return $actions;
	}
	public function actionUsr(){
		return 'sai';
	
	}

}