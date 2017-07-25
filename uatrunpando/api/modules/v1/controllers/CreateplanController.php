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
use app\models\PlanCards;
use app\models\Crops;
class CreateplanController extends ActiveController
{
	public $modelClass = 'app\models\Crops';
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

		unset($actions['login'],$actions['delete'],$actions['view']);

		return $actions;
	}
	public function actionAddcrop()
	{
		$params = Yii::$app->getRequest()->getBodyParams();
		$id=Yii::$app->user->identity->id;
		$q=Yii::$app->db->createCommand('select input_company_id from users where id='.$id)->queryOne();
		$model=new Crops();
		$model->crop_name=$params['crop_name'];
		$model->comp_id=$q['input_company_id'];
		$model->user_id=$id;
		$count=Yii::$app->db->createCommand("select count(*) from crops where crop_name = '".$params['crop_name']."' and comp_id='".$q['input_company_id']."'")->queryScalar();
		if($count>0)
		{
		return 'already exsited crop';
			
		}else{
			
		if($model->save(false))
		{
		 $s=Yii::$app->db->createCommand("select crop_name from crops where comp_id='".$q['input_company_id']."'")->queryAll();
		 //print_r($s);exit;
		return ['message'=>'crop successfully added','list'=>$s];
		}
		else {
			return 'fail';
			}
		}
		
		
		
	}

}