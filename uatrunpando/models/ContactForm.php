<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends \yii\db\ActiveRecord
{
//     public $name;
//     public $email;
//     public $subject;
//     public $message;
//     public $phone_number;
//     public $company_name;
    //public $verifyCode;

   public static function tableName()
    {
    	return 'contactus_details';
    }
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
          //  ['name', 'required', 'message' => '* Please enter your name.'],
            ['email_address', 'required', 'message' => 'Please enter your Email.'],
           // ['phone_number', 'required', 'message' => '* Please enter your phone number.'],
          //  ['company_name', 'required', 'message' => '* Please enter your Company Name.'],
           //['message', 'required', 'message' => '* Please enter a message.'],
        	['message', 'string' ,'max' => 400, 'tooLong' => 'Message limit 400 characters'],
        	[['created_date'], 'safe'],
        	[['name', 'email_address', 'company_name'], 'string', 'max' => 100],
            // email has to be a valid email address
            ['email_address', 'email', 'message' => '* Please enter a valid email.'],
            //phone_number null if empty
            ['phone_number', 'default'], 
            //phone_number has atleast 10 or max 12 digit number
        	//['phone_number', 'match', 'pattern' => '/^[0-9]{10,12}?$/','message' => 'Type your 10 digit number.',],
       		['phone_number', 'number', 'message' => '* Phone Number must be a number.'],
            ['phone_number', 'string' , 'min'=> 10, 'max' => 12 ],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
            'id' => 'ID',
            'name' => 'Name',
            'email_address' => 'Email Address',
            'phone_number' => 'Phone Number',
            'company_name' => 'Company Name',
            'message' => 'Message',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($details)
    {
    		$contact_details = $details['ContactForm'];
       		$send_email = $this->Contactadmin($contact_details);
       		$user_email = $this->Contactuser($contact_details['email_address'],$contact_details['name']);
        	if(($send_email == 1) && ($user_email == 1) )
        	{
        		$this->attributes = $contact_details;
        		$this->message = strip_tags($contact_details['message']);
        		if($this->save(false))
        		{
        			return true;
        		}else {
        			return false;
        		}
        	}else {
        		return false;
        	}
        	
    }
    
     protected function Contactadmin($contact_details)
    {
    	
    	$template = '<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        	<table align="left" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tr>
                	<td align="left" valign="top" style="padding:15px;" >
                    	<!-- BEGIN TEMPLATE // -->
                    	<table border="0" cellpadding="0" cellspacing="0">
                        
                        	<tr>
                            	<td align="left" valign="top">
                                	<!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <h3>Hello PradeepRaj,</h3>
                                               
                                               A request for an enquiry has been raised by one of the customer. Below are the details
                                                <br />
												<br />
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                        		<tr>
                            	<td align="left" valign="top">
                                	<!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td valign="top" >
                                              <table>
                                              		<tbody>';
    												
    												if($contact_details['name'] != '') {
    													
                                              		$template .='<tr>
                                            <td valign="top" style="padding-right: 15px;">Name</td>
    										 <td valign="top">:  </td>
                                             <td valign="top" style="padding-left:10px;">  '.$contact_details['name'].'</td>
                                      		 </tr>';
    											} if ($contact_details['company_name'] != '') {
                                        		$template .= '<tr>
                                            <td valign="top"  style="padding-right: 15px;">Organization</td>
                                              <td valign="top">:  </td>		
                                             <td valign="top" style="padding-left:10px;">  '.$contact_details['company_name'].'</td>
                                       </tr>';
    											} 
                                       $template .= '<tr>
                                            <td valign="top"  style="padding-right: 15px;">Email Id</td>
                                             <td valign="top">:  </td>
                                             <td valign="top" style="padding-left:10px;"> '.$contact_details['email_address'].'</td>
                                       </tr>';
                                             		if ($contact_details['phone_number'] != '') {
                                          $template .= '<tr>
                                            <td valign="top"  style="padding-right: 15px;">Phone</td>
                                              <td valign="top">:  </td>		
                                             <td valign="top" style="padding-left:10px;"> '.$contact_details['phone_number'].'</td>
                                       </tr>';
                                             		} if ($contact_details['message'] != '') {
                                        $template .=  '<tr>
                                            <td valign="top"  style="padding-right: 15px;">Message</td>
                                              <td valign="top">:  </td>		
                                             <td valign="top" style="padding-left:10px;"> '.strip_tags($contact_details['message']).'</td>
                                       </tr>';
                                             		}
                                              		$template .= '</tbody>
                                              </table>
                                            </td>
                                        </tr>
                                        

                                    </tbody>

                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="left" valign="top">
                                	<!-- BEGIN FOOTER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
												  <br />  <br />
                                               Thanks & Regards
                                               <br/>
                                               Pando Help Desk
                                            </td>
                                        </tr>
                                      
                                       
                                    </table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
    </body>';
    	$email = Yii::$app->smtpmail;
    	$email->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
    	$email->addAddress(Yii::$app->params['adminEmail']);
    	$email->CharSet = 'UTF-8';
    	$email->Subject = 'Contact Information';
    	$email->MsgHTML($template);
    	if($email->Send()) {
    		$email->ClearAddresses();
    		return $check = 1;
    	} else {
    		return $check = 0;
    	}
    }
    protected function Contactuser($user_contact,$name)
    {

    	$template = ' <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        	<table align="left" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tr>
                	<td align="left" valign="top" style="padding:15px;" >
                    	<!-- BEGIN TEMPLATE // -->
                    	<table border="0" cellpadding="0" cellspacing="0">
                        
                        	<tr>
                            	<td align="left" valign="top">
                                	<!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
                                                <h3>Hello '.$name.',</h3>
                                               
                                               A support request has been created and a member of our team will be in touch with you shortly.<br/> Thank you for taking time to contact us. 
                                                <br />
												<br />
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                        		<tr>
                            	<td align="left" valign="top">
                                	<!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td valign="top" >
                                             <em> Have a great day! </em>
                                            </td>
                                        </tr>
                                        

                                    </tbody>

                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="left" valign="top">
                                	<!-- BEGIN FOOTER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td valign="top">
												  <br />  <br />
                                               Thanks & Regards,
                                               <br/>
                                               Pando Help Desk.
                                            </td>
                                        </tr>
                                      
                                       
                                    </table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
    </body>
    	';
    	$email = Yii::$app->smtpmail;
    	$email->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
    	$email->addAddress($user_contact);
    	$email->CharSet = 'UTF-8';
    	$email->Subject = 'Contact Information';
    	$email->MsgHTML($template);
    	if($email->Send()) {
    		$email->ClearAddresses();
    		return $check = 1;
    	} else {
    		return $check = 0;
    	}
    }
    
    
}
