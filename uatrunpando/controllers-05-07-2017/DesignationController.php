<?php

namespace app\controllers;

use Yii;
use app\models\Designations;
use app\models\DesignationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\Users;
/**
 * DesignationController implements the CRUD actions for Designations model.
 */
class DesignationController extends KgController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Designations models.
     * @return mixed
     */
    public function actionIndex()
    {
    	
        $searchModel = new DesignationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $actioncolumns = $this->accessindexactioncolumns();
        $linkactions = $this->accesslinkactions();
        $page = Yii::$app->request->get('page');
        $per_page = Yii::$app->request->get('per-page');
        if(!$page && !$per_page) {
        	$geturl = Url::remember(['designation/index','page'=>Yii::$app->request->get('page'),'per-page'=>Yii::$app->request->get('per-page') ],'previous');
        }
        $geturl = Url::remember('',null);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'actioncolumns'=> $actioncolumns,
        	'linkactions' => $linkactions,
        ]);
    }

    /**
     * Displays a single Designations model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Designations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Designations();

        if ($model->load(Yii::$app->request->post()) && $model->designationDupliacte()) {
        	if($model->save(false)) {
        		Yii::$app->session->setFlash('designation-create');
        	}
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Designations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $desmodel = new Designations();
        if ($model->load(Yii::$app->request->post()) && $model->designationDupliacte()) {
        	$designationName = Yii::$app->request->post('Designations')['designation_name'];
        	$sql = Yii::$app->db->createCommand()
        		->update('designations', ['designation_name' => $designationName], ['guid' => $id,'company_id' => Yii::$app->user->identity->input_company_id])
        		->execute();
        		Yii::$app->session->setFlash('designation-update');
        		$this->redirect(Url::previous());
             return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Designations model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $designation_id = Designations::find()->select(['designation_id'])->where(['guid' => $id])->column();
        $designationCount = Users::find()->select('id')->where(['designation_id' => $designation_id[0]])->count();
        //echo '<pre>';print_r($planCrops);exit;
        if($designationCount > 0) {
        	Yii::$app->session->setFlash('designation-restrict');
        } else {
        	$sql = Yii::$app->db->createCommand()
        	->update('designations', ['is_deleted' => 1], ['guid' => $id])
        	->execute();
        	Yii::$app->session->setFlash('designation-delete');
        }
        
        $this->redirect(Url::previous());

        return $this->redirect(['index']);
    }

    /**
     * Finds the Designations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Designations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = Designations::find()->where(['guid' => $id])->one();
    	if ($model !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
        /* if (($model = Designations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
}
