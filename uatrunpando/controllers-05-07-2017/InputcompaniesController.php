<?php

namespace app\controllers;

use Yii;
use app\models\InputCompanies;
use app\models\InputCompaniesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Roles;

/**
 * InputcompaniesController implements the CRUD actions for InputCompanies model.
 */
class InputcompaniesController extends KgController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Lists all InputCompanies models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$actioncolumns = $this->accessindexactioncolumns();
    	$linkactions = $this->accesslinkactions();
        $searchModel = new InputCompaniesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'actioncolumns'=> $actioncolumns,
        	'linkactions' => $linkactions,
        ]);
    }

    /**
     * Displays a single InputCompanies model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$linkactions = $this->accesslinkactions();
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'linkactions' => $linkactions,
        ]);
    }

    /**
     * Creates a new InputCompanies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$loginsession = Yii::$app->session->get('loginid');
    	$kgadmin_role_id = Roles::KGADMIN;
    	$icadmin_role_id = Roles::ICADMIN;
    	$model = new InputCompanies();
        if ($loginsession != '') {
        	$model->scenario = 'iccreate';
        } else {
			$model->scenario = 'iccreateall';
        }
        if ($model->load(Yii::$app->request->post()) && $model->emailunique()&& $model->phone_number_unique()) {
        	if ($model->paid_amount === null || empty($model->paid_amount)) {
        		$model->paid_amount = 0.00;
        	}
        	if ($_POST['save'] == 'saved' && $loginsession == '') {
        		$email = strtolower($model->contact_email);
        		$model->password = $model->password;
        		$password = md5($model->password);
        		$model->designation = '';
        		$model->save(false);
        		if (!$model->save(false)) {
        			print_r($model->getErrors());
        			throw new \yii\web\HttpException(500, Yii::t('yii', 'Some Internal server issue occured.'));
        		}
        		$sql = new \yii\db\Query();
        		$sql->select('id, created_date, created_by, updated_date, updated_by')
	        		->from('input_companies')
	        		->where(['contact_email' => $email]);
        		$sql = $sql->createCommand();
        		$sql = $sql->queryOne();
        		 
        		$sql2 = new \yii\db\Query();
        		$key = rand(1000,10000);
        		$access_token = md5($email.$key);
        		$sql2->createCommand()->insert('users', ['guid' => Yii::$app->guid->generate(), 'phone_number' => $model->phone_number, 'designation' => $model->designation,
        				'email_address' => $email, 'password' => $password, 'input_company_id' => $sql['id'], 'reporting_user_id' => 0, 'created_date' => $sql['created_date'], 'created_by' => $sql['created_by'], 'updated_date' => $sql['updated_date'], 'updated_by' => $sql['updated_by'],
        				'access_token' => $access_token, 'roleid' => $icadmin_role_id ])->execute();
        	} elseif ($_POST['save'] == 'saved' && $loginsession != '') {
        		$email = strtolower($model->contact_email);
//         		$model->password = rand(1000, 10000);
//         		$password = md5($model->password);
        		$model->password = 'Goodluck@123';
        		$password = md5($model->password);
        		$model->designation = $model->designation;
        		$model->save(false);
        		if (!$model->save(false)) {
        			print_r($model->getErrors());
        			throw new \yii\web\HttpException(500, Yii::t('yii', 'Some Internal server issue occured.'));
        		}
        		$sql = new \yii\db\Query();
        		$sql->select('id, created_date, created_by, updated_date, updated_by')
	        		->from('input_companies')
	        		->where(['contact_email' => $email]);
        		$sql = $sql->createCommand();
        		$sql = $sql->queryOne();
        		 
        		$sql2 = new \yii\db\Query();
        		$key = rand(1000,10000);
        		$access_token = md5($email.$key);
        		$sql2->createCommand()->insert('users', ['guid' => Yii::$app->guid->generate(), 'first_name' => $model->person_name, 'phone_number' => $model->phone_number, 'designation' => $model->designation, 'employee_number' => $model->employee_number,
        				'email_address' => $email, 'password' => $password, 'input_company_id' => $sql['id'], 'reporting_user_id' => 0, 'created_date' => $sql['created_date'], 'created_by' => $sql['created_by'], 'updated_date' => $sql['updated_date'], 'updated_by' => $sql['updated_by'],
        				'access_token' => $access_token, 'roleid' => $icadmin_role_id ])->execute();
        	} else {
        		$model->status = 'active';
        		$email = strtolower($model->contact_email);
//         		$model->password = rand(1000, 10000);
//         		$password = md5($model->password);
        		$model->password = 'Goodluck@123';
        		$password = md5($model->password);
        		$model->designation = $model->designation;
        		$model->save(false);
        		if (!$model->save(false)) {
        			print_r($model->getErrors());
        			throw new \yii\web\HttpException(500, Yii::t('yii', 'Some Internal server issue occured.'));
        		}
        		$sql = new \yii\db\Query();
        		$sql->select('id, created_date, created_by, updated_date, updated_by')
	        		->from('input_companies')
	        		->where(['contact_email' => $email]);
        		$sql = $sql->createCommand();
        		$sql = $sql->queryOne();
        		 
        		$sql2 = new \yii\db\Query();
        		$key = rand(1000,10000);
        		$access_token = md5($email.$key);
        		$sql2->createCommand()->insert('users', ['guid' => Yii::$app->guid->generate(), 'first_name' => $model->person_name, 'phone_number' => $model->phone_number, 'designation' => $model->designation, 'employee_number' => $model->employee_number,
        				'email_address' => $email, 'password' => $password, 'input_company_id' => $sql['id'], 'reporting_user_id' => 0, 'status' => $model->status, 'created_date' => $sql['created_date'], 'created_by' => $sql['created_by'], 'updated_date' => $sql['updated_date'], 'updated_by' => $sql['updated_by'],
        				'access_token' => $access_token, 'roleid' => $icadmin_role_id ])->execute();
        	}
        	if ($model->save(false)) {
        		$template = '';
        		$username = '';
        		$password2 = '';
        		if ($_POST['save'] == 'saved' && $loginsession == '') {
        			$subject = 'Organization Creation';
        			$template .= 'Greetings from Kisangates!<br><br> Thank you for registering with us, Your account has been created successfully. <br> Our team will get back to you.<br /><br />
        							 Thank you,  <br /> Pando Support Team, <br /> <a href ="http://www.runpando.com" >www.runpando.com</a>';
        		} elseif ($_POST['save'] == 'saved' && $loginsession != '') {
        			$subject = 'Organization Creation';
        			$template .= 'Greetings from Kisangates!<br><br> Thank you for registering with us, Your account has been created successfully. <br> Our team will get back to you.<br /><br />
        							 Thank you,  <br /> Pando Support Team, <br /> <a href ="http://www.runpando.com" >www.runpando.com</a>';
        		} else {
        			$username .= $email;
        			$password2 .= $model->password;
        			$subject = 'Pando Activation';
        			$template .= "Greetings from Kisangates! <br><br>Your Pando account has been activated successfully.<br><br>
        							Kindly click on the link <a href = 'http://www.runpando.com' >www.runpando.com</a> to manage and review your sales team's performance.
        							 <br /><br /><b>Sign-in with the below credentials</b><br /><br /> \n Username: ".$username. "<br />Password: ".$password2."<br /><br />Please feel free to contact <a href = 'mailto:pandosupport@kisangates.com'>pandosupport@kisangates.com</a>
										for any support.<br /><br />
        							 Thank you,  <br /> Pando Support Team, <br /> <a href ='http://www.runpando.com' >www.runpando.com</a>";
        		}
        		$mail = Yii::$app->smtpmail;
        		$mail->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
        		$mail->addAddress($email);
        		$mail->CharSet = 'UTF-8';
        		$mail->Subject = $subject;
        		$mail->Body    = 'Your company created successfully.';
        		$mail->MsgHTML($template);
        		if ($mail->Send()) {
					Yii::$app->session->setFlash('company-created');        			 
        		} else {
        			echo "Mailer Error: " . $mail->ErrorInfo;
        		}
        	}
        	if (Yii::$app->user->isGuest) {
            	return $this->redirect(['create']);
        	} else {
        		return $this->redirect(['index']);
        	}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InputCompanies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $kgadmin_role_id = Roles::KGADMIN;
        $icadmin_role_id = Roles::ICADMIN;
        $model->scenario = 'icupdate';
        if ($model->load(Yii::$app->request->post()) && $model->emailunique() && $model->employee_id_unique() && $model->phone_number_unique()) {
        	if ($_POST['save'] == 'saved') {
        		$flash = Yii::$app->session->setFlash('company-updated');
        	} elseif ($_POST['save'] == 'saveactivate') {
        		$model->status = 'active';
        		$model->is_blocked = 0;
        		$flash = Yii::$app->session->setFlash('company-activated');
        		if ($model->created_by != 0 && Yii::$app->user->identity->roleid == $kgadmin_role_id) {
//         			$model->password = rand(1000, 10000);
//         			$password = md5($model->password);
        			$model->password = 'Goodluck@123';
        			$password = md5($model->password);
        		}
        	} else {
        		$model->status = 'inactive';
        		$model->is_blocked = 1;
        		$flash = Yii::$app->session->setFlash('company-deactivated');
        	}
        	$email = strtolower($model->contact_email);
        	$model->save(false);

        	$sql = new \yii\db\Query();
        	$sql->select('id')
	        	->from('input_companies')
	        	->where(['contact_email' => $email]);
        	$sql = $sql->createCommand();
        	$sql = $sql->queryColumn();
        	if ($_POST['save'] == 'saveactivate' && $model->created_by != 0 && $model->updated_by == Yii::$app->user->identity->id && Yii::$app->user->identity->roleid == $kgadmin_role_id) {
	        	$sql2 = new \yii\db\Query();
	        	$sql2->createCommand()->update('users', ['first_name'=> $model->person_name, 'password' => $password, 'designation'=> $model->designation, 'phone_number' => $model->phone_number, 'employee_number' => $model->employee_number,
	        			'email_address' => $email, 'reporting_user_id' => 0, 'roleid' => $icadmin_role_id, 'status' => $model->status ], ['email_address' => $email, 'input_company_id' => $sql[0]])->execute();
        	} else {
        		$sql2 = new \yii\db\Query();
        		$sql2->createCommand()->update('users', ['first_name'=> $model->person_name, 'designation'=> $model->designation, 'phone_number' => $model->phone_number, 'employee_number' => $model->employee_number,
        				'email_address' => $email, 'reporting_user_id' => 0, 'roleid' => $icadmin_role_id, 'status' => $model->status ], ['email_address' => $email, 'input_company_id' => $sql[0]])->execute();
        	}
        	if ($model->save(false)) {
        		$template = '';
        		$username = '';
        		$password2 = '';
        		if ($_POST['save'] == 'saveactivate' || $_POST['save'] == 'saveinactivate') {
        			if ($_POST['save'] == 'saveactivate') {
        				$subject = 'Organization Creation';
	        			if ($model->created_by != 0 && Yii::$app->user->identity->roleid == $kgadmin_role_id) {
							$username .= 'Username: '.$email;
		        			$password2 .= 'Password: '.$model->password;
		        			$template .= 'Hi..<br><br>Welcome to Pando!<br><br> Your account has been activated successfully. <br> You can login with below credentials.<br><br>'.$username.'<br>'.$password2.' <br /><br />
        							 Thank you,  <br /> Pando Support Team, <br /> <a href ="http://www.runpando.com">www.runpando.com</a>';
	        			} else {
		        			$template .= 'Hi..<br><br>Welcome to Pando!<br><br> Your account has been activated successfully. <br> You can login with your credentials.<br /><br />
        							 Thank you,  <br /> Pando Support Team, <br /> <a href ="http://www.runpando.com">www.runpando.com</a>';
		        		}
        			} else {
        				$subject = 'Organization De-Activation';
        				$template .= 'Hi..<br><br>Your account is De-activated. <br><br> Please Contact Admin.<br /><br />
        							 Thank you,  <br /> Pando Support Team, <br /> <a href ="http://www.runpando.com">www.runpando.com</a>';
        			}
		        		$mail = Yii::$app->smtpmail;
		        		$mail->setFrom(Yii::$app->params['fromEmail'],Yii::$app->params['fromName']);
		        		$mail->addAddress($email);
		        		$mail->CharSet = 'UTF-8';
		        		$mail->Subject = $subject;
		        		$mail->Body    = 'Your Organization created successfully.';
		        		$mail->MsgHTML($template);
		        		if ($mail->Send()) {
		        			$flash;
		        		} else {
		        			echo "Mailer Error: " . $mail->ErrorInfo;
		        		}
	        	}
        	}
        	return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InputCompanies model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
    	$sql2 = Yii::$app->db->createCommand()
					    	->update('input_companies', ['is_deleted' => 1], ['guid' => $id])
					    	->execute();
        Yii::$app->session->setFlash('company-deleted');
        return $this->redirect(['index']);
    }

    /**
     * Finds the InputCompanies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return InputCompanies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = InputCompanies::find()->where(['guid' => $id])->one();
    	if ($model !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
        /* if (($model = InputCompanies::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
    
    public function actionActivation($id)
    {
    	$sql = InputCompanies::find()->select(['id', 'contact_email' ,'status'])->where(['id'=>$id])->one();
       	if ($sql['id'] == '' ) {
    		echo 'No id match';
    	} elseif ($sql['id'] != $id) {
    		echo 'Invalid id';
    	} else {
    		if ($sql['status'] == 'active') {
    			$sql2 = Yii::$app->db->createCommand()
									->update('input_companies', ['status' => 'inactive'], ['id' => $id])
									->execute();
    			$sql3 = Yii::$app->db->createCommand()
    								->update('users', ['status' => 'inactive'], ['email_address' => $sql['contact_email']])
    								->execute();
    			return $this->redirect(['view', 'id' => $id]);
    		} else {
   				$sql2 = Yii::$app->db->createCommand()
									->update('input_companies', ['status' => 'active'], ['id' => $id])
									->execute();
   				$sql3 = Yii::$app->db->createCommand()
					   				->update('users', ['status' => 'active'], ['email_address' => $sql['contact_email']])
					   				->execute();
    			return $this->redirect(['view', 'id' => $id]);
    		}
    	}
    
    }
}
