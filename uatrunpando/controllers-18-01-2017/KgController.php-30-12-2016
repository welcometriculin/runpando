<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\AuthAssignment;
use app\models\RolePermission;
use yii\web\ForbiddenHttpException;
use app\models\Users;
use app\models\Roles;

class KgController extends Controller
{
	public function beforeAction($action)
	{
		$loginsession =\Yii::$app->session->get('loginid');
		$controllerid = Yii::$app->controller->id;
		$actionid = Yii::$app->controller->action->id;
		$icadmin_role_id = Roles::ICADMIN;
		if ($loginsession) {
			if (Yii::$app->session['userSessionTimeout'] < time()) {
				Yii::$app->session->destroy();
				return $this->redirect(['site/expired']);
			} else {
				Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
			}
		}
		if (Yii::$app->user->isGuest  && ($controllerid =='inputcompanies') && ($actionid == 'create')) {
			return true;
		} elseif ($loginsession != '') {
			if (Yii::$app->user->identity->roleid == $icadmin_role_id) {
				$menuscountusers = Users::getMenus(Yii::$app->user->identity->id);
				if ($menuscountusers > 0 && (($controllerid == 'plancard' && $actionid == 'index') || ($controllerid == 'plancard' && $actionid == 'create') || ($controllerid == 'plancard' && $actionid == 'update') || ($controllerid == 'plancard' && $actionid == 'history') || ($controllerid == 'travellog' && $actionid == 'index') || ($controllerid == 'travellog' && $actionid == 'view') || ($controllerid == 'channelpartners' && $actionid == 'index'))) {
					return true;
				} 
			}
		} elseif ($loginsession == '') {
			return $this->redirect(['site/login']);
		}
	
		/*$sql = Yii::$app->db->createCommand("SELECT permission.controller_name,permission.action_name FROM permission
					     JOIN role_permission ON permission.permission_id = role_permission.permission_id
					     JOIN users ON users.role_id = role_permission.role_id
					     where users.role_id ='".Yii::$app->user->identity->role_id."'
					     and permission.controller_name='".$controllerid."'
					     and permission.action_name='".$actionid."'")->queryOne();*/
		$query = new \yii\db\Query();
		$query->select('p.controller, p.action')
				->from('privileges p')
				->innerJoin('role_privileges_map rpm', 'p.id = rpm.privilege_id')
				->innerJoin('users u', 'u.roleid = rpm.role_id')
				->where(['u.roleid' => Yii::$app->user->identity->roleid,  'p.controller'=> $controllerid, 'p.action' => $actionid]);
		$query = $query->createCommand();
		$queryresp = $query->queryOne();
		//echo '<pre>';
		//print_r($queryresp);
		//exit;
		if (Yii::$app->user->identity->id != '' && ($controllerid == $queryresp['controller']) &&  ($actionid == $queryresp['action']) && Yii::$app->user->identity->status == 'active' && Yii::$app->user->identity->is_blocked == 0 && Yii::$app->user->identity->is_deleted == 0) {
			return true;
		} else {
			throw new ForbiddenHttpException("You don't have permissions to access this page.");
		}
		//session timeout
		if (!parent::beforeAction($action)) {
			return false;
		}
		
		if ( !Yii::$app->user->isGuest) {
			if (Yii::$app->session['userSessionTimeout'] < time()) {
				Yii::$app->session->destroy();
				return $this->redirect(['site/expired']);
			} else {
				Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
				return true;
			}
		} else {
			return true;
		}
		//session timeout
	}
	
    public function accessindexactioncolumns()
    {
    	$view = 'view';
		$update = 'update';
		$delete = 'delete';
		$controllerid = Yii::$app->controller->id;
		//$actionid = Yii::$app->controller->action->id;
		/*$sql = Yii::$app->db->createCommand("SELECT p.action FROM privileges p
					     JOIN role_privileges_map ON p.id = role_privileges_map.privilege_id
					     JOIN users ON users.roleid = role_privileges_map.role_id
					     where users.roleid ='".Yii::$app->user->identity->roleid."'
					     and p.controller='".$controllerid."'")->queryAll();*/
		$query = new \yii\db\Query();
		$query->select('p.action')
			->distinct()
			->from('privileges p')
			->innerJoin('role_privileges_map rpm', 'p.id = rpm.privilege_id')
			->innerJoin('users u', 'u.roleid = rpm.role_id')
			->where(['u.roleid' => Yii::$app->user->identity->roleid,  'p.controller' => $controllerid]);
		$query = $query->createCommand();
		$queryresp = $query->queryAll();
		//echo '<pre>';
		//print_r($queryresp);exit;
		foreach ($queryresp as $key => $value) {
			$permissions[] = $value['action'];	
		}
// 		echo '<pre>';
// 		print_r($permissions);
// 		exit;

		$checking_actions = array("update", "delete");
		$result = array_intersect($permissions, $checking_actions);
		$actioncolumns = implode('}{', $result);
		return $actioncolumns;
		
		/*if(!in_array($view, $permissions) && !in_array($update, $permissions) && !in_array($delete, $permissions)){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn', 'visible'=>false];
			return $actioncolumns;
		}
		else if(in_array($view, $permissions) && in_array($update, $permissions) && in_array($delete, $permissions)){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$view.'} '.'{'.$update. '} '.'{'. $delete.'}'];
			return $actioncolumns;
		}
		else if(in_array($view, $permissions) && (!in_array($update, $permissions) && !in_array($delete, $permissions))){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$view.'} '];
			return $actioncolumns;
		}
		else if((in_array($view, $permissions) && in_array($update, $permissions)) && !in_array($delete, $permissions)){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$view.'} '.'{'.$update. '} '];
			return $actioncolumns;
		}
	    else if(in_array($view, $permissions) && !in_array($update, $permissions) && in_array($delete, $permissions)){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$view.'} '.'{'.$delete. '}'];
			return $actioncolumns;
		}
		else if(in_array($update, $permissions) && (!in_array($view, $permissions) && !in_array($delete, $permissions))){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$update.'} '];
			return $actioncolumns;
		}
		else if(!in_array($view, $permissions) && (in_array($update, $permissions) && in_array($delete, $permissions))){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$update.'} '.'{'.$delete. '} '];
			return $actioncolumns;
		}
		else if(in_array($delete, $permissions) && (!in_array($update, $permissions) && !in_array($view, $permissions))){
			$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$delete. '} '];
			return $actioncolumns;
		}*/
    }
    
  public function accesslinkactions()
    {
    	$create = 'create';
    	$update = 'update';
    	$delete = 'delete';
    	$controllerid = Yii::$app->controller->id;
    	//$actionid = Yii::$app->controller->action->id;
		/*$sql = Yii::$app->db->createCommand("SELECT p.action FROM privileges p
					     JOIN role_privileges_map ON p.id = role_privileges_map.privilege_id
					     JOIN users ON users.roleid = role_privileges_map.role_id
					     where users.roleid ='".Yii::$app->user->identity->roleid."'
					     and p.controller='".$controllerid."'")->queryAll();*/
    	$query = new \yii\db\Query();
    	$query->select('p.action')
	    	->distinct()
	    	->from('privileges p')
	    	->innerJoin('role_privileges_map rpm', 'p.id = rpm.privilege_id')
	    	->innerJoin('users u', 'u.roleid = rpm.role_id')
	    	->where(['u.roleid' => Yii::$app->user->identity->roleid,  'p.controller'=> $controllerid]);
    	$query = $query->createCommand();
    	$queryresp = $query->queryAll();
    	
		foreach ($queryresp as $key => $value) {
			$linkactions[] = $value['action'];
		}
    	//$linkactions = explode(',', $sql['action_name']);
		$checking_actions2 = array("create", "view");
		$result2 = array_intersect($linkactions, $checking_actions2);
		$linkactions = $result2;
    	return $linkactions;


    }
}
/*else if(in_array($view, $a) && !in_array($update, $a) && in_array($delete, $a)){
	$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$view.'} '.'{'.$delete. '} {activeblock}',
	'buttons' => [

	'activeblock' => function ($url,$model,$key) {
		return Html::a('Action', $url);
	},],];
	return $actioncolumns;
}*/
/*else if(in_array($view, $a) && !in_array($update, $a) && in_array($delete, $a)){
	$actioncolumns = ['class' => 'yii\grid\ActionColumn','template' => '{'.$view.'} '.'{'.$delete. '} {activeblock}',
	'buttons' => [

	'activeblock' => function ($url,$model,$key) {
		if($model->active == 'Active'){
			return Html::a('Block', $url);
		}
		else{
			return Html::a('Active', $url);
		}
	},],];
	return $actioncolumns;
}*/
?>
