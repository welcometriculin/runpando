<?php

namespace app\controllers;

use Yii;
use app\models\RolePrivilegesMap;
use app\models\RolePrivilegesMapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleprivilegesmapController implements the CRUD actions for RolePrivilegesMap model.
 */
class RoleprivilegesmapController extends Controller
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
     * Lists all RolePrivilegesMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RolePrivilegesMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RolePrivilegesMap model.
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
     * Creates a new RolePrivilegesMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RolePrivilegesMap();

           if ($model->load(Yii::$app->request->post())) {
	        	$roleid = $model->role_id;
	        	$controller = $model->controller_id;
	        	$values = (isset($_POST['actionnames']) ? array_values($_POST['actionnames']) : '');
	        	if (!empty($values)) {
		        	$action_ids = implode(',', $_POST['actionnames']);
		        	$sql = "INSERT INTO role_privileges_map (role_id, privilege_id) VALUES";
		        	$sql2 = '';
		        	foreach ($values as $value) {
		        		$sql2 .= "('".$roleid."', '".$value."'),";	
		        	}
		        	$sql3 = trim($sql2, ',');
		        	$s = $sql.$sql3;
		        	$select = "SELECT controller FROM privileges WHERE id IN($action_ids)";
		        	$select = Yii::$app->db->createCommand($select)->queryColumn();
		        	//print_r($select[0]);exit;
		        	$select2 = "SELECT id FROM privileges WHERE controller = '".$select[0]."'";
		        	$select2 = Yii::$app->db->createCommand($select2)->queryColumn();
		        	$action_ids2 = implode(',', $select2);
		        	//print_r($action_ids2);exit;
		        	$delete = "DELETE FROM role_privileges_map WHERE role_id='".$roleid."' AND privilege_id IN($action_ids2)";
		        	Yii::$app->db->createCommand($delete)->execute();
		        	Yii::$app->db->createCommand($s)->execute();
	        	} else {
		        	$delete = "DELETE rpm FROM role_privileges_map rpm
		        			INNER JOIN privileges p ON p.id = rpm.privilege_id 
		        			WHERE rpm.role_id='".$roleid."' 
		        			AND p.controller = '".$controller."'";
		        	Yii::$app->db->createCommand($delete)->execute();
	        	}
	            return $this->redirect(['create']);
        	} else {
	            return $this->render('create', [
	                'model' => $model,
	            ]);
        }
    }

    /**
     * Updates an existing RolePrivilegesMap model.
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
     * Deletes an existing RolePrivilegesMap model.
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
     * Finds the RolePrivilegesMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RolePrivilegesMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RolePrivilegesMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionPermissionactions($roleid, $controllername)
    {
    	//echo $controllername;
    	//exit;
    	$loginsession =\Yii::$app->session->get('loginid');
    	/*if(!isset($loginsession))
    	 {
    	return $this->redirect(['site/login']);
    	}*/
    
    	$httpurl = $_SERVER['HTTP_REFERER'];
    	$httpurl = explode('/',$httpurl);
    	$httpurl = end($httpurl);
    	$sql = "SELECT p.controller, p.action 
    			FROM privileges p
		    	JOIN role_privileges_map rpm ON p.id = rpm.privilege_id
		    	JOIN users u ON u.roleid = rpm.role_id
		    	WHERE rpm.role_id ='".$roleid."'
		    	AND p.controller='".$controllername."'";
    	//echo 'g';exit;
    	//$sql = "select action_name from permission where controller_name ='".$controllername."'";
    	$sql = Yii::$app->db->createCommand($sql)->queryAll();
    	if (!empty($sql)) {
    		foreach ($sql as $sql2) {
    			$sql3[] = $sql2['action'];
    		}
    	} else {
    		$sql3[] = '';
    	}
    	//print_r($sql3); exit;
    	$data2 ='';
    	$controlleractions = "SELECT p.id, p.action FROM privileges p
    						  WHERE p.controller ='".$controllername."'";
    	$controlleractions = Yii::$app->db->createCommand($controlleractions)->queryAll();
    	//echo '<pre>';
    	//print_r($controlleractions);
    	//exit;
    	//$controllername = ucfirst($controllername).'Controller';
    	//$permissionactions = Yii::$app->metadata->getActions($controllername);
    	 
    	$checked ='';
    	$data1 = '';
    	if (count($controlleractions) > 0) {
    		foreach ($controlleractions as $key => $data) {
    			$permissionaction = strtolower($data['action']);
    			if ($httpurl = 'create') {
    				if (in_array($permissionaction, $sql3)) {
    					$checked = 'checked';
    				} else {
    					$checked = '';
    				}
    			}
    			$data1 .= "<input type='checkbox' name='actionnames[]' value='".$data['id']."'  $checked>".$permissionaction.'</br>';
    		}
    	} else {
    		$data1 .= "No data";
    	}
    	return $data1;
    }
}
