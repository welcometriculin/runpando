<?php

namespace app\controllers;

use Yii;
use app\models\TravelLog;
use app\models\TravelLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\YearTravellog;
use app\models\Users;

/**
 * TravellogController implements the CRUD actions for TravelLog model.
 */
class TravellogController extends KgController
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
     * Lists all TravelLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TravelLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_id = Yii::$app->user->identity->id;
        // 		$reportees_list[$user_id] = 'All';
        $rep = Users::getChildsRecoursive($user_id,true);
        $reportUsers = Users::dashboardUsers($rep);
        $reportUsers = array($user_id => 'All') + $reportUsers;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'data'			=> $reportUsers
        ]);
    }

    /**
     * Displays a single TravelLog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$date)
    {
    	$searchModel = new TravelLogSearch();
    	$dataProvider = $searchModel->details(Yii::$app->request->queryParams);
//     	echo '<pre>';print_r($dataProvider['distance_travelled']);exit;
    	return $this->render('view', [
            'model' => $this->findModel($id),
    		'searchModel' => $searchModel,
        	'dataProvider' => $dataProvider['dataProvider'],
    		'distance_travelled_sum' => $dataProvider['distance_travelled']	
        ]);
    }

    /**
     * Creates a new TravelLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TravelLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TravelLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing TravelLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TravelLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TravelLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = TravelLog::find()->where(['guid' => $id])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
