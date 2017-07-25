<?php

namespace app\api\modules\v2\models;

use Yii;
use yii\web\UploadedFile;
use app\api\modules\v2\models\Roles;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email_address
 * @property string $password
 * @property integer $roleid
 * @property integer $input_company_id
 * @property integer $reporting_to
 * @property string $status
 * @property string $access_token
 * @property string $auth_key
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 *
 * @property CampaignCardActivities[] $campaignCardActivities
 * @property ChannelCardActivities[] $channelCardActivities
 * @property PlanCards[] $planCards
 * @property Role $role
 */
class Users extends Kg
{
	const USER_STATUS_ACTIVE = 'active';
	const USER_STATUS_INACTIVE = 'inactive';
	
	public $reporting_user_role;
	public $confirm_password; //for resetpassword
	public $old_password; //for change password
	public $bulkfile; //for bulk upload users
	public $employee; //for performance users dropdown
	public $free_text_search;//for keyword search
    /**
     * @inheritdoc
     */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['userprofile'] = ['first_name', 'last_name','email_address', 'phone_number', 'designation'];
		$scenarios['changepassword'] = ['password', 'old_password','confirm_password'];
		return $scenarios;
	}
	
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['password','required','message' => 'New Password cannot be blank','on' => 'changepassword'],
            //[['first_name', 'last_name', 'phone_number', 'email_address', 'password', 'roleid', 'input_company_id', 'reporting_user_id', 'status', 'access_token', 'auth_key', 'created_date', 'created_by', 'updated_date', 'updated_by'], 'required'],
        	[['first_name', 'employee_number','email_address', 'phone_number', 'roleid', 'reporting_user_role', 'reporting_user_id', 'password', 'created_date', 'created_by', 'updated_date', 'updated_by'], 'required'],
        	[['first_name', 'employee_number','email_address', 'phone_number', 'password', 'confirm_password', 'old_password', 'state', 'district', 'head_quarters', 'area_of_operatoin'], 'filter', 'filter' => 'trim'],
        	[['roleid', 'input_company_id',  'created_by', 'updated_by'], 'integer'],
        	[['first_name', 'head_quarters', 'area_of_operatoin'], 'match', 'pattern' => '/^[a-zA-Z\s]+$/'],
        	//[['status'], 'string'],
            [['state', 'district', 'head_quarters', 'area_of_operatoin'], 'safe'],
        	['email_address', 'email'],
        	[['employee_number'], 'string', 'max' => 50],
        	//['employee_number', 'match', 'pattern' => '/[^0]+[0]?$/'],//not accept only zero and accepts zero with combination of other characters
        	//['employee_number', 'match', 'pattern' => '^(?=.*[a-z])|(?=.*[A-Z])|(?=.*\d)|(?=.*[$@#/!%*?&():_+^])^'],
            [['created_date', 'updated_date'], 'safe'],
            [['first_name', 'last_name', 'password'], 'string', 'max' => 50],
            [['photo'], 'file', 'isEmpty' => true, 'extensions' => 'png, jpg', 'minSize' => 1024 * 5, 'tooSmall' => 'File minimum size should be 5kb', 'maxSize' => 1024 * 20, 'tooBig' => 'File maximum size should be 20kb'],
            //[['phone_number'], 'string', 'max' => 15],
        	[['phone_number'], 'number'],
        	[['phone_number'], 'string', 'min' => 10, 'max' => 12],
            [['email_address', 'access_token', 'auth_key'], 'string', 'max' => 100],
            //['reporting_user_role','checkForRole']
            ['confirm_password', 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Confirm Password doesn't match"],
        	['old_password', 'required'],
        	[['password'], 'string', 'min' => 6],
        	['password', 'match', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&()_+^])[A-Za-z\d$@#!%*?&()_+^]{6,}^', 'message' => 'Password should contain One small alphabet (a-z), Minimum one capital alphabet (A-Z) and minimum one numeric (0-9). and one special characters'],
        	['bulkfile', 'required'],
        	[['bulkfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv'],
        		
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Employee Name',
            'last_name' => 'Last Name',
            'employee_number' => 'Employee ID',
            'phone_number' => 'Phone Number',
            'email_address' => 'Email Address',
            'password' => 'Password',
            'roleid' => 'Employee Role',
            'input_company_id' => 'Input Company ID',
            'reporting_user_role' => 'Reporting Manager Role',
            'reporting_user_id' => 'Reporting Manager Name',
            'reporting_to' => 'Reporting Manager Name',
            'state' => 'State',
            'district' => 'District',
            'head_quarters' => 'Headquarters',
            'area_of_operation' => 'Area of Operation',
            'status' => 'Status',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
        	'bulkfile' =>'Bulk Users'	
        ];
    }
    /* profile details web service data  start*/
  public static function getData()
  {
	$id = Yii::$app->user->identity->id;
	/* $query = new \yii\db\Query;
   	$query->select('g1.id, g1.first_name, g1.phone_number, g1.employee_number, g1.head_quarters, g1.email_address, g1.photo, g1.photo_path, s1.first_name as reporting_manager')
          ->from('users g1')
          ->innerJoin('users s1', 's1.id = g1.reporting_user_id')  
          ->where(['g1.id' => $id]); */
	$query = "SELECT g1.id, g1.first_name, g1.phone_number, g1.employee_number, IF (g1.head_quarters IS NULL, '', g1.head_quarters) as head_quarters, g1.email_address, g1.photo, g1.photo_path, s1.first_name AS reporting_manager 
			FROM users g1
			INNER JOIN users s1 ON s1.id = g1.reporting_user_id 
			WHERE g1.id = :id";
	$resp = Yii::$app->db->createCommand($query)
					->bindValue(':id', $id)
					->queryAll();
  	return $resp;	
  }
  /* profile details web service data  end*/
  
  /* web service for forgot password start */
  
  public static function forGotpas($email)
  {
  	$ffofficer_role_id = Roles::FIELDFORCE;
 	$sql = Users::find()->select(['email_address', 'roleid'])->where(['email_address' => $email])->one();
 	if (count($sql) > 0 && $sql['roleid'] == $ffofficer_role_id) {
 		$password = rand(1000, 10000);
 		$command = yii::$app->db->createCommand('UPDATE users SET password = "'.md5($password).'" WHERE email_address = "'.$email.'"');
      	$command->execute();
      	$template = 'Greetings from Kisangates!<br><br> &nbsp;&nbsp;A new password had been generated on your request,Below are the details. <br><br>
      				&nbsp;&nbsp;Username: '.$email.'<br> &nbsp;&nbsp;Password: '.$password.'<br /><br />
        							 Thank you,  <br /> Pando Support Team <br /> <a href ="http://www.runpando.com" >www.runpando.com</a>';
 		$mail = Yii::$app->smtpmail;
	    $mail->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
        $mail->addAddress($email);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Reset Password';
        $mail->MsgHTML($template);
 		if ($mail->Send()) {
 			return ['details' => 'New password will sent to your email address,please check you email', 'forgotstatus' => true];
 		} else {
 			return $mail->ErrorInfo;
 		}
 	} elseif (count($sql) > 0 && $sql['roleid'] != $ffofficer_role_id) {
 		return ['details' => 'you are not authorized user', 'forgotstatus' => false];
 	} else {
 		return ['details' => 'your email is incorrect', 'forgotstatus' => false];
 	}
  	
  }
  
  /* web service for forgot password end */
  
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignCardActivities()
    {
        return $this->hasMany(CampaignCardActivities::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannelCardActivities()
    {
        return $this->hasMany(ChannelCardActivities::className(), ['userid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanCards()
    {
        return $this->hasMany(PlanCards::className(), ['assign_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'roleid']);
    }
    
    public function emailunique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$email = strtolower($this->email_address);
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);

    	if ($loginsession == '') {
    		$sql= Users::find()->select('email_address')->where(['email_address' => $email])->count();
    	} elseif ($httpurl == 'create') {
    		$sql= Users::find()->select('email_address')->where(['email_address' => $email])->count();
    	} elseif ($httpurl != 'create') {
    		$sql= Users::find()->select('email_address')->where(['email_address' => $email])->andWhere(['!=', 'id', $this->id])->count();
    	}
    	if ($sql > 0) {
    		$this->addError('email_address', "Email already exist. Please try another one");
    		return false;
    	}
    	else {
    		return true;
    	}
    }
    //for users creation phone number unique start
    public function phone_number_unique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$phone_number = $this->phone_number;
    	$phone_length = strlen($this->phone_number);
    	$email = strtolower($this->email_address);
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);
    	if ($httpurl == 'create') {
    		$sql = Users::find()->select('phone_number')->column();
    	} else {
    		$sql = Users::find()->select('phone_number')->where(['!=', 'guid', $this->guid])->column();
    	}
    	if ((in_array($phone_number, $sql) || in_array('91'.$phone_number, $sql) || in_array(substr($phone_number, -10), $sql)) && $phone_length != 11) {
    		$this->addError('phone_number', "Phone Number already exist. Please try another one");
    		return false;
    	} elseif ($phone_length == 11) {
    		$this->addError('phone_number', "Phone Number format is wrong. Please try again");
    		return false;
    	} else {
    		return true;
    	}
    }
    //for users creation phone number unique end
    //for employee id unique start
    public function employeeid_unique()
    {
    	$employee_id = $this->employee_number;
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);
    	if ($httpurl == 'create') {
    		$sql = Users::find()->select('employee_number')->where(['input_company_id' => Yii::$app->user->identity->input_company_id])->column();
    	} else {
    		$sql = Users::find()->select('employee_number')->where(['input_company_id' => Yii::$app->user->identity->input_company_id])->andWhere(['!=', 'id', $this->id])->column();
    	}
    	if (in_array($employee_id, $sql)) {
    		$this->addError('employee_number', "Employee ID already exist.");
    		return false;
    	} else {
    		return true;
    	}
    }
    //for employee id unique end
    //for bulk users start
    public function bulkemailunique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$sql = Users::find()->select('email_address')->column();
    	return $sql;
    }

    public function bulkphoneunique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$sql = Users::find()->select('phone_number')->column();
    	return $sql;
    }
    
    public function bulk_employeeid_unique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$sql = Users::find()->select('employee_number')->where(['input_company_id' => Yii::$app->user->identity->input_company_id])->column();
    	return $sql;
    }
    
    public function bulk_reporting_user_employee_ids()
    {
    	$sql = new \yii\db\Query();
    	$sql->select('GROUP_CONCAT(employee_number) AS employee_number, roleid')
		    ->from('users')
		    ->where(['input_company_id' => Yii::$app->user->identity->input_company_id])
		    ->groupBy('roleid');
    	$sql = $sql->createCommand();
    	$sql = $sql->queryAll();
    	foreach ($sql as $s) {
    		$result[$s['roleid']] = $s['employee_number'];
    	}
    	return $result;
    }	
    
    public static function bulkEmail($email)
    {
    	$mail = Yii::$app->smtpmail;
    	$mail->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
    	foreach ($email as $key_email => $password) {
	    	$mail->addAddress($key_email);
	    	$template = 'Greetings from Kisangates! <br /><br /> Your account created successfully. <br> You can login into your account by using below credentials. <br>Username: '.$key_email. '<br> Password: '.$password.'<br><br>Thank You, <br />Pando Support Team<br /><a href ="http://www.runpando.com">www.runpando.com</a>';
	    	$mail->addCc(Yii::$app->params['fromEmail']);
	    	$mail->CharSet = 'UTF-8';
	    	$mail->Subject = 'User creation';
	    	$mail->MsgHTML($template);
	    	if ($mail->Send()) {
	    		$mail->ClearAddresses();
	    		$flash = '';
	    	} else {
	    		$flash = 'Mails are not sending';
	    	}
    	}
    }
    //for bulk users end
	public static function getReportingUserName($id)
	{
		$query = new \yii\db\Query();
		$query->select('u.first_name, u.last_name')
				->from('users u')
				->innerJoin('users uu', 'uu.reporting_user_id = u.id')
				->where(['uu.id' => $id]);
		$query = $query->createCommand();
		$queryresp = $query->queryOne();
		return $queryresp;
	}
	
	public static function getMenus($user_id)
	{
		$ffofficer_role_id = Roles::FIELDFORCE;
		$menu = new \yii\db\Query();
		$menu->select('count(uu.id)')
				->from('users u')
				->innerJoin('users uu', 'uu.reporting_user_id = u.id')
				->where(['u.input_company_id' => Yii::$app->user->identity->input_company_id, 'u.id' => Yii::$app->user->identity->id])
				->andWhere(['uu.roleid' => $ffofficer_role_id])
				->andWhere(['or', 'uu.is_deleted = 0', 'uu.is_blocked = 0']);
		$menu = $menu->createCommand();
		$menuresp = $menu->queryScalar();
		return $menuresp;
	}
	
	public static function getEmployeeID($company_id)
	{
		$query = new \yii\db\Query();
		$query->select('u.employee_number')
				->from('users u')
				->innerJoin('input_companies ic', 'u.input_company_id = ic.id AND ic.contact_email = u.email_address')
				->where(['ic.id' => $company_id]);
		$query = $query->createCommand();
		$queryresp = $query->queryOne();
		return $queryresp;
	}
	/* web service for signup start */ 
	public static function signUp($params)
	{
		$password = md5($params['password']);
		$get_ph_number = Yii::$app->db->createCommand("SELECT email_address, phone_number FROM users WHERE email_address = :email_address")
						->bindValue(':email_address', $params['email_address'])
						->queryOne();
		$sql = Users::find()->select(['email_address', 'phone_number', 'password'])->where(['phone_number' => $params['phone_number'], 'email_address'=> $params['email_address']])->andWhere(['=', 'is_deleted', 0])->one();
		if (count($sql) == 1) {
			$query = Yii::$app->db->createCommand("SELECT is_blocked FROM users WHERE email_address = '".$params['email_address']."' AND phone_number = '".$params['phone_number']."'")
						->queryOne();
			if ($query['is_blocked'] != 0) {
				return ['details' => 'your account in deactivate mode', 'signupstatus'=> false];
			} else {
				$command = Yii::$app->db->createCommand()
						->update('users', ['password' => $password, 'status' => 'active'], ['phone_number' => $params['phone_number']])
						->execute();
				return ['details'=>'Your account has been activated. Please login with your credentials', 'signupstatus'=> true];
			}
		} elseif (count($sql) == 0) {
			if ($get_ph_number['email_address'] != $params['email_address']) {
				return ['details'=>'invalid email id', 'signupstatus' => false];
			} elseif ($get_ph_number['email_address'] == $params['email_address'] && $get_ph_number['phone_number'] != $params['phone_number']) {
				$ph_no = substr($get_ph_number['phone_number'], 0, 3).'XXXX'.substr($get_ph_number['phone_number'], 7, 10);
				return ['details'=>"invalid mobile number. Your number is $ph_no", 'signupstatus' => false];
			}
		} else {
			return ['details'=>'invalid email/mobile no','signupstatus' => false];
		}
	}
	/* web service for signup end */
	
   public function changepasswordcheck()
    {
		$loginsession = Yii::$app->session->get('loginid');
		$old_password = md5($this->old_password);
		$newpassword = md5($this->password);
		$old_password_check = Users::find()->select('password')->where(['id' => $loginsession])->one();
		if ($old_password != $old_password_check['password']) {
			$this->addError('old_password', 'Old password is incorrect');
			return false;
		} elseif ($old_password == $newpassword) {
			$this->addError('password', 'New password should not be same as old password');
			return false;
		} else {
			$sql = (new \yii\db\Query());
			$sql->createCommand()
				->update('users', ['password' => $newpassword], ['id' => $loginsession])
				->execute();
			Yii::$app->session->setFlash('change-password-success');
			return true;
		}
    }
    
   public static function userProfile()
   {
   	$user_id = Yii::$app->user->identity->id;
   	$details = Users::find()->select('*')->where(['id' => $user_id])->one();
    return $details; 	
   } 
   
   public static function getReportingManagers($users) 
   {
     $managerIds = array();
   	 if(count($users)>0) {
   	 	$uniqueUsers = array_unique($users);
   	 	$managerIds = Users::find()->select('reporting_user_id as id, group_concat(id) as reportees')->where(['id' => $uniqueUsers])->andWhere(['!=','reporting_user_id',0])->groupBy('reporting_user_id')->asArray()->all();
   	 }
   	 return $managerIds;
   }
	/* web service for profile edit */
   public static function userProfileEdit($params)
   {
   	$user_id = Yii::$app->user->identity->id;
   	$email = Yii::$app->user->identity->email_address;
	$phone_number = $params['phone_number'];
	if ($params['photo'] != '') {
	   	header("Content-type:jpg");
	   	$data = base64_decode($params['photo']);
	   	$source_img = imagecreatefromstring($data);
	   	$rotated_img = imagerotate($source_img, 360, 100);
	   	$file = '../web/user_images/'.uniqid(). '.jpg';
	   	$image_file = explode('/', $file);
	   	$image_name = $image_file[3];
	   	$imageSave = imagejpeg($rotated_img, $file, 10);
	   	$image_path = 'user_images/';
		$sql = (new \yii\db\Query());
		$sql->createCommand()
			->update('users', ['phone_number' => $phone_number, 'photo' => $image_name, 'photo_path' => $image_path], ['id' => $user_id])
			->execute();
	} else {
		$sql = (new \yii\db\Query());
		$sql->createCommand()
			->update('users', ['phone_number' => $phone_number], ['id' => $user_id])
			->execute();
	}
	if (!$sql) {
		return $message = 'Not saved';
	} else {
		return $message = 'saved';
	}
   }
	/* web service for profile edit end */
	
   /* web service for change password start */
  public static function changePassword($params)
  {
  	$user_id = Yii::$app->user->identity->id;
  	$old_password = md5($params['old_password']);
  	$newpassword = md5($params['new_password']);
	$old_password_check = Users::find()->select('password')->where(['id' => $user_id])->one();
	if ($old_password != $old_password_check['password']) {
		return ['message' => 'Old password is incorrect', 'status' => true];
	} elseif ($old_password == $newpassword) {
		return ['message' => 'Old & New passwords are same', 'status' => true];
	} else {
		$sql = (new \yii\db\Query());
		$sql->createCommand()
			->update('users', ['password'=> $newpassword], ['id' => $user_id])
			->execute();
		return ['data' => 'Your Password is changed successfully', 'status' => true];
	}
  }
  /* web service for change password end */
   
  //reportees users list 
  public static function Reporteeslist(){
  	$id=Yii::$app->user->identity->id;
  	$query = new \yii\db\Query();
  	$query->select('uu.id,uu.first_name,uu.email_address')
  	->from('users u')
  	->innerJoin('users uu', 'u.id = uu.reporting_user_id')
  	->where(['u.id' =>$id])->andWhere(['!=', 'uu.id', $id]);
  	$query = $query->createCommand();
  	$queryresp = $query->queryAll();
  	$listData = ArrayHelper::map($queryresp,'id',function ($element) {
   return $element['first_name'] . ' ('. $element['email_address'].')';
});
  	return $listData;
  
  }
  
  //for web dependency actions
  public static function dependencyUserActions($id)
  {
  	$sql = 'select count(p.id) as count, u.roleid from users u
  			left join plan_cards p on u.id = p.assign_to
  			where u.guid = "'.$id.'"';
  	$result = Yii::$app->db->createCommand($sql)->queryOne();
  	return $result;
  }
  public static function dependencyUsers($id)
  {
  	$sql = 'select count(u.id) as count, u.roleid from users u
  			JOIN users uu on uu.reporting_user_id = u.id 
  			where u.guid = "'.$id.'"';
  	$result = Yii::$app->db->createCommand($sql)->queryOne();
  	return $result;
  }
  public static function ffList($mm_id, $flag)
  {		
  	$comp_id = Yii::$app->user->identity->input_company_id;
  	  	$list =  Users::find()->select('id,first_name,email_address')->where(['input_company_id' =>$comp_id,'roleid' => 4,'reporting_user_id' => $mm_id,'status'=> 'active' ])->asArray()->all();
  		if ($flag == 'create') {
  		$dropdown = '<option value = "" >Select Field Force Name </option>';
  		if(!empty($list)) {
  			foreach ($list as $drop) {
  				$dropdown .= "<option value = '".$drop['id']."' >".ucfirst($drop['first_name']).' ('.$drop['email_address'].')'."</option>";
  			}
  		}
  		//	$dropdown .='<option value = "add-new-elements" style = "background-color:#5e4091;color:white">Add New</option>';
  		return $dropdown;
  	} else {
  		return $list;
  	}
  	
/*   	$fflist =  Users::find()->select('id,first_name,email_address')->where(['input_company_id' =>$comp_id,'roleid' => 4 ])->asArray()->all();
  	return $listData = ArrayHelper::map($fflist,'id','first_name'); */
  	
  } 
  
  public static function managerList()
  {
  	$comp_id = Yii::$app->user->identity->input_company_id;
  	$mmlist =  Users::find()->select('id,first_name,email_address')->where(['input_company_id' =>$comp_id,'roleid' => 3,'status' => 'active' ])->asArray()->all();
  	return $listData = ArrayHelper::map($mmlist,'id','first_name');
  }
  public static function feildList()
  {
  	$comp_id = Yii::$app->user->identity->input_company_id;
  	$mmlist =  Users::find()->select('id,first_name,email_address')->where(['input_company_id' =>$comp_id,'roleid' => 4,'status' => 'active' ])->asArray()->all();
  	return $listData = ArrayHelper::map($mmlist,'id','first_name');
  }
  public static function reportManager($mm_id)
  {
  	$rep_id = Users::find()->select('reporting_user_id')->where(['id' => $mm_id])->one();
  	$mmlist =  Users::find()->select('id,first_name')->where(['id' => $rep_id['reporting_user_id'] ])->one();
  	$dropdown = "<option selected value = '".$mmlist['id']."' >".ucfirst($mmlist['first_name'])."</option>";
  	return json_encode($dropdown);
  }
  
  public function reportingEmpid()
  {
  	$loginsession = Yii::$app->session->get('loginid');
  	$c_id = Yii::$app->user->identity->input_company_id;
  	$sql8 = Users::find()->select('employee_number')->where(['roleid' => Roles::MANAGER,'input_company_id' =>$c_id ])->orWhere(['roleid' =>Roles::ICADMIN])->column();
  	return $sql8;
  }
  public function employeenameUnique()
  {
  	$loginsession = Yii::$app->session->get('loginid');
  	$employee_number = strtolower($this->first_name);
  	$httpurl = $_SERVER['HTTP_REFERER'];
  	$httpurl = explode('/',$httpurl);
  	$httpurl = end($httpurl);
  	$cm_id = Yii::$app->user->identity->input_company_id;
  	if ($loginsession == '') {
  		$sql= Users::find()->select('first_name')->where(['first_name' => $employee_number,'input_company_id' => $cm_id])->count();
  	} elseif ($httpurl == 'create') {
  		$sql= Users::find()->select('first_name')->where(['first_name' => $employee_number,'input_company_id' => $cm_id])->count();
  	} elseif ($httpurl != 'create') {
  		$sql= Users::find()->select('first_name')->where(['first_name' => $employee_number,'input_company_id' => $cm_id])->andWhere(['!=', 'id', $this->id])->count();
  	}
  	if ($sql > 0) {
  		$this->addError('first_name', "first name already exist. Please try another one");
  		return false;
  	}
  	else {
  		return true;
  	}
  }
  
  public function firstnameCheck()
  {
  	$loginsession = Yii::$app->session->get('loginid');
  	$c_id = Yii::$app->user->identity->input_company_id;
  	$sql8 = Users::find()->select('first_name')->where(['roleid' =>Roles::MANAGER,'input_company_id' =>$c_id ])->orWhere(['roleid' => Roles::ICADMIN])->column();
  	return $sql8;
  }
}
