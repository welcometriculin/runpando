<?php

/**
 * @link http://www.yiiframework.com/
* @copyright Copyright (c) 2008 Yii Software LLC
* @license http://www.yiiframework.com/license/
*/

namespace yii\rest;

use Yii;
use yii\base\Model;
use yii\base\Security;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use app\models\Roles;
/**
 * CreateAction implements the API endpoint for creating a new model from the given data.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAction extends Action
{
	/**
	 * @var string the scenario to be assigned to the new model before it is validated and saved.
	 */
	public $scenario = Model::SCENARIO_DEFAULT;
	/**
	 * @var string the name of the view action. This property is need to create the URL when the model is successfully created.
	 */
	public $viewAction = 'view';


	/**
	 * Creates a new model.
	 * @return \yii\db\ActiveRecordInterface the model newly created
	 * @throws ServerErrorHttpException if there is any error when creating the model
	 */
	public function run()
	{
	 
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $model = new $this->modelClass();

        $ffofficer_role_id = Roles::FIELDFORCE;
       // $str = 'YmFzZTY0IGVuY29kZWQgc3RyaW5n';
       // echo base64_decode($str);
        	$params = Yii::$app->getRequest()->getBodyParams();
     		$email = $params['email'];
     		$password = md5($params['password']);
        	$model2 = $this->modelClass;
            $query = $model2::find()->where(['email_address'=>$email, 'password'=>$password])->andWhere(['roleid' => $ffofficer_role_id])->one();	
        	if (count($query) == 1 && $query['status'] == 'active' && $query['is_blocked'] == 0 && $query['is_deleted'] == 0) {
        		/*$key=rand(1000,10000);
    		$access_token=md5($email.$key);
      		$command = yii::$app->db->createCommand('UPDATE users SET access_token="'.$access_token.'" WHERE email_address="'.$email.'"');
      		$command->execute();*/
        	$query = new \yii\db\Query;
      		$query->select('g1.id,g1.access_token,g1.first_name,g1.last_name,g1.phone_number,g1.employee_number,g1.head_quarters,g1.email_address,g1.photo,g1.photo_path,s1.first_name as reporting_manager')
         		 ->from('users g1')
         		 ->innerJoin('users s1', 's1.id =g1.reporting_user_id')  
         		 ->where(['g1.email_address'=>$email]);
			$command = $query->createCommand();
			$resp = $command->queryOne();
			return ['details'=>$resp,'status'=>true];	
        	} elseif ($query['is_blocked'] == 1 && $query['is_deleted'] == 0) {
        		return ['details'=>'Your account is De-activated','status'=>false];
        	} elseif ($query['is_blocked'] == 1 && $query['is_deleted'] == 1) {
        		return ['details'=>'Your account is Blocked/Deleted','status'=>false];
        	} else {
        		return ['details'=>'username/password is invalid','status'=>false];
        	}
     		 
    }
}
