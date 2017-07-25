<?php
namespace app\components;
use yii\base\Component;

class SMS 
{
	public static function SmsSend($phone_number, $message)
	{
		//$admsms='Hello %name%. You are admitted in %class% for session %session%. www.smsg.com';
		//$sms=str_ireplace(array('%name%','%class%','%session%'),array('Indrajit Lahiri','Nursery','2015-16'),$admsms);
		$message = str_replace(' ','%20', $message);
		// to replace the space in message with '%20'
		//$url='http://login.smsgatewayhub.com/api/mt/SendSMS?APIKey=734e2e2e-58e7-440e-b7a7-bc4aca12f2c6&senderid=WEBSMS&channel=2&DCS=0&flashsms=0&number='.$phone_number.'&text='.$message.'&route=1';
		// create a new cURL resource
		$url = 'http://dnd.vtel.in/api/sentsms.php?username=kisan&api_password=bb9f418cf7&to='.$phone_number.'&priority=2&sender=KISANA&message='.$message;
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL,$url);
		//for hide response message
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// grab URL and pass it to the browser
		curl_exec($ch);
		// close cURL resource, and free up system resources
		curl_close($ch);
		return true;
	}
}