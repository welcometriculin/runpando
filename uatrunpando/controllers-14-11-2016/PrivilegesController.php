<?php

namespace app\controllers;

use Yii;
use app\models\Privileges;
use app\models\PrivilegesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrivilegesController implements the CRUD actions for Privileges model.
 */
class PrivilegesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Privileges models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrivilegesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Privileges model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Privileges model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Privileges();

        if ($model->load(Yii::$app->request->post())) {
        	$controller_actions = Privileges::find()->select('action')
        											->where(['controller' => $model->controller])
        											->column();
        	$controller = $model->controller;
        	$action = array_values($_POST['actionnames']);
        	$sql = "INSERT INTO privileges ( controller, action) VALUES";
        	$sql2 = '';
        	foreach ($action as $actionvalue) {
        		if (!in_array($actionvalue, $controller_actions)) {
        			$sql2 .= "('".$controller."', '".$actionvalue."'),";
        		}
        	}
        	$sql3 = trim($sql2, ',');
        	$sql4 = $sql.$sql3;
        	Yii::$app->db->createCommand($sql4)->execute();
//         	Yii::$app->db->createCommand()->batchInsert('privileges', ['controller', 'action'], [
//         	[$model->attributes],
//         	])->execute();
        	$model->save();
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Privileges model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Privileges model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Privileges model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Privileges the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Privileges::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPrivilegeactions()
    {
    	if ($_REQUEST && isset($_REQUEST['controller'])) {
    		$controllername = $_REQUEST['controller'];
    		$id = $_REQUEST['id'];
    	}
    	$loginsession =\Yii::$app->session->get('loginid');
    	/*if(!isset($loginsession))
    	{
    		return $this->redirect(['site/login']);
    	}*/
    	 
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);
    	 
    	if ($id != 0) {
    		$sql2 = "AND id = '".$id."'";
    	} else {
    		$sql2 = '';
    	}
    	$sql = "SELECT action FROM privileges WHERE controller ='".$controllername."' $sql2";
    	$sql = Yii::$app->db->createCommand($sql)->queryAll();
    	if (!empty($sql)) {
	    	foreach ($sql as $key => $sql2) {
	    		$sql3[] = $sql2['action'];
	    	}
    	} else {
    		$sql3[] = '';
    	}
    	//print_r($sql3);exit;
    	$data ='';
    	$controllername = ucfirst($controllername).'Controller';
    	$privilegeactions = Yii::$app->metadata->getActions($controllername);
    	//print_r($privilegeactions);exit;
    	$checked ='';
    	if (count($privilegeactions) > 0) {
    		foreach ($privilegeactions as $privilegeaction) {
    			$privilegeaction = strtolower($privilegeaction);
    				if (in_array($privilegeaction, $sql3)) {
    					$checked = 'checked';
    				} else {
    					$checked = '';
    				}
    			
    			$data .= "<input type='checkbox' name='actionnames[]' value='".$privilegeaction."'  $checked>".$privilegeaction.'</br>';
   			}
    	} else {
    		$data .= "No data";
    	}
    	return $data;
    }
}
