<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use yii\helpers\Url;
use app\models\Roles;

class SiteController extends Controller
{
	public $enableCsrfValidation = false;
	public function behaviors()
	{
		return [
				'access' => [
						'class' => AccessControl::className(),
						'only' => ['logout'],
						'rules' => [
								[
										'actions' => ['logout'],
										'allow' => true,
										'roles' => ['@'],
								],
						],
				],
				'verbs' => [
						'class' => VerbFilter::className(),
						'actions' => [
								'logout' => ['post'],
								//'login' => ['get'],
						],
				],
		];
	}

	//     public function beforeAction($action)
	//     {
	//     	$loginsession = Yii::$app->session;
	//     	if($loginsession['loginid'])
		//     		return $this->redirect(['plancard/index']);
		//     	return parent::beforeAction($action);
		//     }
// 	public function beforeAction($action)
// 	{
	
// 		if (!parent::beforeAction($action)) {
// 			return false;
// 		}
	
// 		// Check only when the user is logged in
// 		if ( !Yii::$app->user->isGuest)  {
// 			if (Yii::$app->session['userSessionTimeout'] < time()) {
// 				Yii::$app->user->logout();
// 			} else {
// 				Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
// 				return true;
// 			}
// 		} else {
// 			return true;
// 		}
// 	}
		public function actions()
		{
			return [
					'error' => [
							'class' => 'yii\web\ErrorAction',
					],
					'captcha' => [
							'class' => 'yii\captcha\CaptchaAction',
							'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
					],
			];
		}

		public function actionIndex()
		{
			$loginsession = Yii::$app->session;
			if ($loginsession['loginid']) {
				return $this->redirect(['users/profile']);
			}  /*else {
				return $this->redirect(['login']);
			}*/
			$model = new ContactForm();
			if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->request->post())) {
				Yii::$app->session->setFlash('contactus-success', 'Thank you for contacting us');
				return $this->redirect(['index#contact']);
			}
			return $this->render('index', [
					'model' => $model,
			]);			
		}

		public function actionLogin()
		{
			/* if (!\Yii::$app->user->isGuest) {
			 return $this->goHome();
			 }*/
			//echo 's';exit;
			$loginsession = Yii::$app->session;
			if ($loginsession['loginid']) {
				return $this->redirect(['dashboard/index']);
			}
			$message = '';
			$ffofficer_role_id = Roles::FIELDFORCE;
			$model = new LoginForm();
			if ($model->load(Yii::$app->request->post()) ) {
				$query = \app\models\Users::find()->select('ic.status, ic.is_blocked')->from('users u')
												->innerJoin('input_companies ic', 'ic.id = u.input_company_id')
												->where(['u.email_address' => $model->email_address])
												->one();
				if ($query['status'] == 'inactive' && $query['is_blocked'] == 0) {
					$message = 'Your organization is not activated';
				} elseif ($query['status'] == 'inactive' && $query['is_blocked'] == 1) {
					$message = 'Your organization is de-activated';
				} else {
					if ($model->login() !='' && $model->login() == 1) {
						if (Yii::$app->user->identity->status == 'active' && Yii::$app->user->identity->is_blocked == 0 && Yii::$app->user->identity->roleid != $ffofficer_role_id) {
							\Yii::$app->session->set('loginid',Yii::$app->user->identity->id);
							\Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
							$loginsession =\Yii::$app->session->get('loginid');
							if (isset($loginsession)) {
								if(Yii::$app->user->identity->roleid == 1){
								return $this->redirect(['users/profile']);
							} else {
								return $this->redirect(['dashboard/index']);
							}
							}
						} elseif (Yii::$app->user->identity->roleid == $ffofficer_role_id) {
							\Yii::$app->session->remove('loginid');
							$message= 'You are not authorized to login';
								
						} else {
							if (Yii::$app->user->identity->is_blocked == 0) {
								\Yii::$app->session->remove('loginid');
								$message = 'Your account is not activated, please contact admin';
							} else {
								\Yii::$app->session->remove('loginid');
								$message = 'Your account is de-activated, please contact admin';
							}
						}
					}
				//return $this->goBack();
				}
			}
			return $this->render('login', [
					'model' => $model, 'message'=>$message
			]);
		}

		public function actionLogout()
		{
			Yii::$app->user->logout();

			return $this->goHome();
		}

		//     public function actionContact()
		//     {
		//         $model = new ContactForm();
		//         if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
		//            // Yii::$app->session->setFlash('contactFormSubmitted');

		//             return $this->refresh();
		//         }
		//         return $this->render('contact', [
		//             'model' => $model,
		//         ]);
		//     }

		public function actionAbout()
		{
			return $this->render('about');
		}

		public function actionGid()
		{

			$model = new Users();
			$model->roleid = 2;
			$model->save(false);
			//return $this->render('about');
		}

		public function actionForgotpassword()
		{
			$model = new Users();
			$user_active = Users::USER_STATUS_ACTIVE;
			$user_inactive = Users::USER_STATUS_INACTIVE;
	 	if ($model->load(Yii::$app->request->post())) {
	 		$emailcheckcount = Users::find()->where(['email_address'=> $model->email_address])->count();
	 		$user_status = Users::find()->where(['email_address'=> $model->email_address])->one();
	 		if ($emailcheckcount == 1 && $user_status['status'] == $user_active) {
	 			$key = rand(1000, 10000);
	 			$key = md5($model->email_address.$key);
	 			$generate_auth_key = (new \yii\db\Query());
	 			$generate_auth_key->createCommand()
					 			->update('users', ['auth_key'=> $key], ['email_address' => $model->email_address])
					 			->execute();
	 			$auth_key = $key;
	 			$reset_password_info = 'Hi..<br><br> Click below link to reset your password <br>';
	 			$reset_password_url = Yii::$app->request->hostInfo.Url::home().'/site/resetpassword?activation_key='.$auth_key;
	 			$reset_password_url = $reset_password_info. $reset_password_url. '<br><br>Regards <br> Kisan Gates Support Team';
	 			$mail = Yii::$app->smtpmail;
	 			$mail->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
	 			$mail->addAddress($model->email_address);
	 			$mail->CharSet = 'UTF-8';
	 			$mail->Subject = 'Reset Password';
	 			$mail->Body    = 'Click link to reset password';
	 			$mail->MsgHTML($reset_password_url);
	 			if ($mail->Send()) {
	 				Yii::$app->session->setFlash('forgot-password-success');
	 			} else {
	 				echo "Mailer Error: " . $mail->ErrorInfo;
	 			}
	 		} elseif ($user_status['status'] == $user_inactive) {
	 			Yii::$app->session->setFlash('forgot-password-fail');
	 		}  else {
	 			Yii::$app->session->setFlash('forgot-password-failure');
	 		}
	 		$model->email_address = '';
	 		return $this->redirect(['forgotpassword']);
	 	}
	 	return $this->render('forgotpassword', ['model' => $model]);
		}

		public function actionResetpassword($activation_key)
		{
			$model = new Users();
			if ($model->load(Yii::$app->request->post())) {
				$password = md5($model->password);
				$usercheck = Users::find()->select('id, status, auth_key, is_deleted')
										->where(['auth_key'=> $activation_key])
										->one();
				if ($usercheck['auth_key'] != '' && $usercheck['auth_key'] == $activation_key) {
					$sql = (new \yii\db\Query());
					$sql->createCommand()
						->update('users', ['password' => $password, 'auth_key' => ''], ['auth_key' => $activation_key])
						->execute();
					Yii::$app->session->setFlash('reset-password-success', 'Your Password is reset successfully');
				} else {
					Yii::$app->session->setFlash('reset-password-failure', 'Your Password link is expired');
				}
			}
			return $this->render('resetpassword', ['model' => $model]);
		}
	//error handling
	public function actionHand()
	{
		return $this->render('404');
		
	}
	public function actionExpired()
	{
			$loginsession = Yii::$app->session;
			if ($loginsession['loginid']) {
				return $this->redirect(['dashboard/index']);
			}
		return $this->render('expired');
		
	}
        
}
