<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\Roles;
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
    //profile details service data
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
    		$sql = \app\models\Users::find()->select('phone_number')->column();
    	} else {
    		$sql = \app\models\Users::find()->select('phone_number')->where(['!=', 'guid', $this->guid])->column();
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
    		$sql = \app\models\Users::find()->select('employee_number')->where(['input_company_id' => Yii::$app->user->identity->input_company_id])->andWhere(['!=', 'id', $this->id])->column();
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
  	$mmlist =  Users::find()->select('id,first_name,email_address')->where(['input_company_id' =>$comp_id,'roleid' => [Roles::MANAGER, Roles::ICADMIN],'status' => 'active' ])->asArray()->all();
  	return $listData = ArrayHelper::map($mmlist,'id','first_name');
  }
  public static function feildList()
  {
  	$comp_id = Yii::$app->user->identity->input_company_id;
  	$mmlist =  Users::find()->select('id,first_name,email_address')->where(['input_company_id' =>$comp_id,'roleid' => Roles::FIELDFORCE,'status' => 'active' ])->asArray()->all();
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
  // dashboard dropdown users
  public static function dashboardUsers($res)
   {
  	$repquery = new \yii\db\Query();
  	$repquery->select('u.id,u.first_name,r.role_name')
			  	->from('users u')
			  	->innerJoin('roles r' ,'r.id = u.roleid')
			  	->where(['u.id' => $res])
  				->orderBy('u.first_name asc');
  	$repquery = $repquery->createCommand();
  	$queryresp = $repquery->queryAll();
  	$listArray = array();
  	if(!empty($queryresp)) {
  		$listArray = ArrayHelper::map($queryresp,'id',function ($element) {
  			return ucfirst($element['first_name']) . ' - '. ucfirst($element['role_name']);
  		});
  	}
  	return $listArray;
  }
  
  // reporting ids for dropdown search
  public static function getChildsRecoursive($parentid,$recoursive=false)
  {
  	$companyIds = \app\models\Users::find()->select('id')->where(['reporting_user_id'=>$parentid])->asArray()->all();
  	$r = array();
  	global $ids;
  	foreach($companyIds as $data){
  		$cid = $data['id'];
  		$ids[] = $data['id'];
  		if($recoursive) {
  			$data['childs'] = Users::getChildsRecoursive($cid, true);
  		}
  		$r[] = $data;
  	}
  	return $ids;
  }
  
  public static function getRecoursive($pid,$recoursive=false)
  {
  	//echo 'rec'.$pid;exit;
  	$companyIds = Users::find()->select('roleid,id')->where(['reporting_user_id'=>$pid])->asArray()->all();
  	if(empty($companyIds)) {
  		return $pid;
  	}
  	// echo '<pre>';print_r($companyIds);exit;
  	$r = array();
  	global $Reportids;
  	foreach($companyIds as $data){
  		$cid = $data['id'];
  		if($data['roleid'] == 4) {
  			$Reportids[] = $data['id'];
  		}
  		if($recoursive) {
  			$data['childs'] = Users::getRecoursive($cid, true);
  		}
  		$r[] = $data;
  	}
  	return $Reportids;
  }
  public static function getPartners($fieldForce)
  {
  	$partnerInfo= array();
  	if(!empty($fieldForce)) {
  		$parterIds = ChannelPartners::find()->select('channel_partner_name')
  		->where(['user_id' => $fieldForce])
  		->orderBy('channel_partner_name ASC')
  		->column();
  	}
  	if(!empty($parterIds)) {
  		foreach($parterIds as $Info) {
  			$partnerInfo[$Info] = $Info;
  		}
  	}
  	//echo '<pre>ud';print_r($parterIds);exit;
  	 
  	/* $Partnernames = PartnerMaster::find()->select('partner_id,partner_name')
  	->where(['partner_id'=>$parterIds])
  	->orderBy('partner_name ASC')
  	->asArray()->all(); */
  	//$Partnernames = ArrayHelper::map($parterIds,'channel_partner_name','channel_partner_name');
  	//echo '<pre>ud';print_r($Partnernames);exit;
  	 
  	return $partnerInfo;
  
  }
  
}
