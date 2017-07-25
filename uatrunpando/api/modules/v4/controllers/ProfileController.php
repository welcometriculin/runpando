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
use yii\base\Security;
use app\api\modules\v4\models\Users;
use app\api\modules\v4\models\WebService;

class ProfileController extends ActiveController
{
	public $modelClass = 'app\api\modules\v4\models\Users';
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
		$web_model = new WebService();
		$web_model->user_id = Yii::$app->user->identity->id;
		$web_model->params = json_encode($params);
		$web_model->service_name = 'profile_edit';
		$web_model->save(false);
		$result = Users::userProfileEdit($params);
		if($result == 0){
			return ['data' => 'Phone number already exists', 'status' => false];
		}
		else{
			return ['data' => 'Profile successfully edited', 'status' => true];
		}
		//return ['data' => 'Profile successfully edited', 'status' => true];
	}

	public function actionChangepassword()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$web_model = new WebService();
		$web_model->user_id = Yii::$app->user->identity->id;
		$web_model->params = json_encode($params);
		$web_model->service_name = 'change_password';
		$web_model->save(false);
		$result = Users::changePassword($params);
		return $result;
	}
	
}
