<?php

namespace app\models;

use Yii;
use kartik\password\StrengthValidator;


/**
 * This is the model class for table "input_companies".
 *
 * @property string $id
 * @property string $guid
 * @property string $organization_name
 * @property string $person_name
 * @property string $contact_email
 * @property string $phone_number
 * @property string $paid_amount
 * @property string $number_of_licences
 * @property string $status
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 */
class InputCompanies extends Kg
{
	public $designation;
	public $password;
	public $confirm_password;
	public $employee_number;
	public $checkbox;
    /**
     * @inheritdoc
     */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		//$scenarios['signin'] = ['username', 'password'];
		$scenarios['iccreate'] = ['organization_name', 'person_name', 'contact_email', 'number_of_licences', 'paid_amount', 'phone_number', 'designation','checkbox', 'contact_person_name', 'license_information', 'employee_number'];
		$scenarios['icupdate'] = ['organization_name', 'person_name', 'contact_email', 'number_of_licences', 'paid_amount', 'phone_number', 'designation', 'checkbox', 'contact_person_name', 'license_information', 'employee_number'];
		$scenarios['iccreateall'] = [ 'contact_email','phone_number','password', 'confirm_password', 'checkbox'];
		return $scenarios;
	}
	
    public static function tableName()
    {
        return 'input_companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['guid', 'organization_name', 'person_name', 'contact_email', 'phone_number', 'paid_amount', 'number_of_licences', 'status', 'created_date', 'created_by', 'updated_date', 'updated_by'], 'required'],
        	[['organization_name', 'person_name', 'contact_email', 'phone_number', 'password', 'confirm_password', 'employee_number'], 'required'],
        	[['organization_name', 'person_name', 'contact_email', 'number_of_licences','phone_number', 'password', 'confirm_password', 'paid_amount', 'designation', 'employee_number'], 'filter', 'filter' => 'trim'],
    		[['checkbox'], 'required', 'message' => 'Please accept the terms and conditions'],
        	[['person_name', 'contact_person_name', 'organization_name', 'designation',], 'match', 'pattern' => '/^[a-zA-Z\s]+$/'],
        	['license_information', 'match', 'pattern' => '/[0-9a-zA-Z\s]+$/'],
        	//['license_information', 'match', 'pattern' => '/[^-0]|[^0-]+[0-9a-zA-Z\s]?$/'],
        	['contact_email', 'email'],
        	['paid_amount', 'number'],
        	[['employee_number'], 'string', 'max' => 50],
        	//['employee_number', 'match', 'pattern' => '/[^0]+[0]?$/'],//not accept only zero and accepts zero with combination of other characters
        	//['paid_amount', 'default', 'value'=> 0.00],
        	['paid_amount', 'match', 'pattern' => '/^[0-9]{4,6}[.]{1,1}[0-9]{2,2}?$/', 'message' => 'please enter amount like 1000.00'],
        	//[['password'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'person_name'],
            //[['paid_amount'], 'number'],
            [['status'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            //[['created_by', 'updated_by'], 'default', 'value' => 0],
            [['guid'], 'string', 'max' => 50],
            [['organization_name', 'person_name', 'contact_email'], 'string', 'max' => 100],
           //[['phone_number'], 'string', 'max' => 15],
        	[['phone_number'], 'number'],
        	[['phone_number'], 'string', 'min' => 10, 'max' => 12],
        	[['password'], 'string', 'min' => 8, 'max' => 16],
            [['number_of_licences'], 'string', 'max' => 10],
            [['guid'], 'unique'],
            [['designation', 'contact_person_name', 'paid_amount', 'license_information'], 'safe'],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Confirm Password doesn't match"],
            ['password', 'match', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@#!%*?&()_+^])[A-Za-z\d$@#!%*?&()_+^]{6,}^','message' => 'Min one small alphabet(a-z), capital alphabet(A-z), numeric(0-9) and special character'],
		];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'organization_name' => 'Organization',
            'person_name' => 'Person Name',
            'contact_email' => 'Email Address',
            'phone_number' => 'Phone Number',
            'paid_amount' => 'Payment Made',
            'number_of_licences' => 'Number of App users',
            'status' => 'Status',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
        	'employee_number'=> 'Employee ID'
        ];
    }
    
    public static function getDesignation($id)
    {
    	$sql = (new \yii\db\Query())
		  		->select('u.designation, u.employee_number')
				->from('users u')
				->innerJoin('input_companies ic', 'ic.contact_email = u.email_address')
				->where(['ic.id' => $id])
    			->one();
    	return $sql;
    }
    
    public function emailunique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$email = strtolower($this->contact_email);
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);

    	if ($loginsession == '' || $loginsession != '' && $httpurl == 'create') {
    		$sql= Users::find()->select('email_address')->where(['email_address' => $email])->count();
    	} elseif ($httpurl != 'create' && $loginsession != '' ) {
    		$sql= InputCompanies::find()->select('contact_email')->where(['contact_email' => $email])->andWhere(['!=', 'id', $this->id])->count();
    	}
    	if ($sql > 0) {
    		$this->addError('contact_email', "Email already exist. Please try another one");
    		return false;
    	} else {
    		return true;
    	}
    }
    //for ic creation employeeid unique start
    public function employee_id_unique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$email = strtolower($this->contact_email);
    	$employee_number = $this->employee_number;
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);
    	if ($httpurl == 'create') {
    		$sql = \app\models\Users::find()->select('employee_number')->where(['!=', 'employee_number', 0])->column();
    	} else {
    		$sql = \app\models\Users::find()->select('employee_number')->where(['!=', 'employee_number', 0])->andWhere(['!=', 'email_address', $email])->column();
    	}
    	if (in_array($employee_number, $sql)) {
    		$this->addError('employee_number', "Employee ID already exist. Please try another one");
    		return false;
    	} else {
    		return true;
    	}
    }
    //for ic creation employeeid unique end
    //for ic creation phone number unique start
    public function phone_number_unique()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$phone_number = $this->phone_number;
    	$phone_length = strlen($this->phone_number);
    	$email = strtolower($this->contact_email);
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);
    	if ($httpurl == 'create') {
    		$sql = \app\models\Users::find()->select('phone_number')->column();
    	} else {
    		$sql = \app\models\Users::find()->select('phone_number')->where(['!=', 'email_address', $email])->column();
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
    //for ic creation phone number unique end
    public static function getOrganizationprofile()
    {
	    $user_id = Yii::$app->user->identity->id;
	    $details = (new \yii\db\Query())
			    ->select('ic.*, u.*')
			    ->from('users u')
			    ->innerJoin('input_companies ic', 'u.input_company_id = ic.id AND u.email_address = ic.contact_email')
			    ->where(['u.input_company_id' => Yii::$app->user->identity->input_company_id, 'u.id' => Yii::$app->user->identity->id])
				->one();
	    	return $details;
    }
    //for company list drop down
    public static function companyList(){
    
    	$sql = InputCompanies::find()->select(['id', 'organization_name'])
    		->where(['status' => 'active', 'is_deleted' => 0, 'is_blocked' => 0])
    		->orderBy(['organization_name' => SORT_ASC])
    		->all();
    	$companyList = array();
    	$list = $sql;
    		if (!empty($list)) {
    			foreach ($list as $value) {
    				$companyList[] = array('id' => $value['id'], 'organization_name' => ucfirst($value['organization_name']));
    			}
    		}
    		return $companyList;
    }
}
