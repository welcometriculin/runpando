<?php
namespace app\api\modules\v2\controllers;
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
use yii\base\Security;
use app\api\modules\v2\models\Users;

class ProfileController extends ActiveController
{
	public $modelClass = 'app\api\modules\v2\models\Users';
	/*public $serializer = [
			'class' => 'yii\rest\Serializer',
			'collectionEnvelope' => 'items',
	];*/
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
	
		unset($actions['delete'],$actions['view'],$actions['create']);
		// customize the data provider preparation with the "prepareDataProvider()" method
		//$actions['login']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
	
		return $actions;
	}
	public function actionDetails(){
		//return 'dasd';
		 $data = Users::getData();
		return ['profile'=>$data,'profile_status'=>true];
	}
	public function actionEdit()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$result = Users::userProfileEdit($params);
		return ['data' => 'Profile successfully edited', 'status' => true];
	}

	public function actionChangepassword()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$result = Users::changePassword($params);
		return $result;
	}
	
}
