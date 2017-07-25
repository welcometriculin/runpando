<?php

namespace app\controllers;

use Yii;
use app\models\SubActivity;
use app\models\SubActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Activity;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\helpers\Url;
/**
 * SubactivityController implements the CRUD actions for SubActivity model.
 */
class SubactivityController extends KgController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                   // 'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SubActivity models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$page = Yii::$app->request->get('page');
    	$per_page = Yii::$app->request->get('per-page');
    	if(!$page && !$per_page) {
    		$geturl = Url::remember(['subactivity/index','page'=>Yii::$app->request->get('page'),'per-page'=>Yii::$app->request->get('per-page') ],'previous');
    	}
    	$geturl = Url::remember('',null);
    	$actioncolumns = $this->accessindexactioncolumns();
    	$linkactions = $this->accesslinkactions();
        $searchModel = new SubActivitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new SubActivity();
        $fhv_id = Activity::FHV;
        $fgm_id = Activity::FGM;
        $mc_id = Activity::MC;
        $demo_id = Activity::DEMO;
        $finalData = array();
        $temp = array();
        if (Yii::$app->request->post()) {
        	$model->bulkactivities = UploadedFile::getInstance($model, 'bulkactivities');
        	$model->bulkactivities->saveAs(Yii::getAlias('@webroot').'/import/'.$model->bulkactivities);
        	$csv = $model->bulkactivities;
        	$inputFile = '../web/import/'.$csv;
        	try {
        		$inputFileType = \PHPExcel_IOFactory::identify($inputFile);
        		$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
        		$objPHPExcel = $objReader->load($inputFile);
        	} catch (Exception $e) {
        		die('bulk Activity error');
        	}
        	$sheet = $objPHPExcel->getSheet(0);
        	$highestRow = $sheet->getHighestRow();
        	$highestColumn = $sheet->getHighestColumn();
        	$check = 1;
        	$row2 = 1;
        	$rowDataheader = $sheet->rangeToArray('A'.$row2.':'.$highestColumn.$row2,NULL,TRUE,FALSE);
        	if(empty($rowDataheader[0][0])) {
        		$check = 0;
        		$flash = Yii::$app->session->setFlash('bulkactivities-wrong-file');
        		return $this->redirect(['index']);
        	}
        	if (strip_tags($rowDataheader[0][1]) != 'Activity Name' || strip_tags($rowDataheader[0][2]) != 'Sub Activity Name' || $highestColumn != 'C') {
        		$check = 0;
        		$flash = Yii::$app->session->setFlash('bulkactivities-wrong-file');
        	}
        	if ($check == 1) {
	        	for ($row = 2; $row <= $highestRow; $row++) {
	        		$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);	        	
	        		if(!array_key_exists(strtolower(trim($rowData[0][1])).'_'.strtolower(trim($rowData[0][2])),$temp)) {
	        			$temp[strtolower(trim($rowData[0][1])).'_'.strtolower(trim($rowData[0][2]))] = true;
	        	if($rowData[0][1] != '' && $rowData[0][2] != '' && !in_array(strtolower(trim($rowData[0][2])), $model->uniqueCheckUpload())){
	        		$finalData[$row]['guid'] = Yii::$app->guid->generate();
	        		$finalData[$row]['activity_id'] = strip_tags($rowData[0][1]);
	        		if (trim($finalData[$row]['activity_id']) == 'Farm and Home Visit') {
	        			$finalData[$row]['activity_id'] = $fhv_id;
	        		} elseif (trim($finalData[$row]['activity_id']) == 'Farmer Group Meeting') {
	        			$finalData[$row]['activity_id'] = $fgm_id;
	        		} elseif (trim($finalData[$row]['activity_id']) == 'Mass Campaign') {
	        			$finalData[$row]['activity_id'] = $mc_id;
	        		} elseif (trim($finalData[$row]['activity_id']) == 'Demonstration') {
	        			$finalData[$row]['activity_id'] = $demo_id;
	        		}
	        		$finalData[$row]['sub_activity_name'] = strip_tags(trim($rowData[0][2]));
	        		$finalData[$row]['company_id'] = Yii::$app->user->identity->input_company_id;
	        		$finalData[$row]['created_by'] = Yii::$app->user->identity->id;
	        		$finalData[$row]['updated_by'] = Yii::$app->user->identity->id;
	        	} else {
	        		$duplicate_list[$rowData[0][1]][] = $rowData[0][2];
	        	}
	        		} else {
	        			$duplicate_list[$rowData[0][1]][] = $rowData[0][2];
	        		}
	        	}
        	}
        	//$sql = "insert into sub_activity (guid, activity_id, sub_activity_name, company_id, created_by, created_date, updated_by, updated_date) values";
        	//$sql2 = '';
        	if ($check == 1) {
	        	if (!empty($finalData)) {
	        		$count = count($finalData);
	        		foreach ($finalData as $value) {
	        			//$sql2 .= "('".$value['guid']."', '".$value['activity_id']."', '".$value['sub_activity_name']."', '".$value['company_id']."', '".$value['created_by']."', NOW(), '".$value['updated_by']."', NOW()),";
	        			//$sql2 .= '("'.$value['guid'].'", "'.$value['activity_id'].'", "'.$value['sub_activity_name'].'", "'.$value['company_id'].'", "'.$value['created_by'].'", NOW(), "'.$value['updated_by'].'", NOW()),';
	        			$bulk_subactivites_array[] = array($value['guid'], $value['activity_id'], $value['sub_activity_name'], $value['company_id'],$value['created_by'],new Expression('NOW()'), $value['updated_by'],new Expression('NOW()'));
	        		}
	        		//$sql3 = trim($sql2, ',');
	        	//	$sub_activity = $sql . $sql3;
	        		//$sub_activity_insert = Yii::$app->db->createCommand($sub_activity)->execute();
	        		$sub_activity_insert = Yii::$app->db->createCommand()
	        											->batchInsert('sub_activity', ['guid', 'activity_id', 'sub_activity_name', 'company_id', 'created_by', 'created_date', 'updated_by', 'updated_date'],
	        												$bulk_subactivites_array)
	        											->execute();
	        		unlink($inputFile);
	        		if(empty($duplicate_list)) {
	        			$flash = Yii::$app->session->setFlash('bulkactivities-success',$count.'  subactivites inserted');
	        		} else {
	        			$flash = Yii::$app->session->setFlash('bulkactivities-duplicate-insert','unique values are inserted successfully and duplicate are not inserted');
	        		}
	        	} else {
	        		$flash = Yii::$app->session->setFlash('bulkactivities-empty');
	        	}
        	}
        	return $this->refresh();
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'model' => $model,
        	'actioncolumns'=> $actioncolumns,
        	'linkactions' => $linkactions,
        ]);
    }

    /**
     * Displays a single SubActivity model.
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
     * Creates a new SubActivity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SubActivity();
        $channel_id = Activity::CHANNEL;
        $activities = Activity::find()->where(['!=', 'activity_id', $channel_id])->all();
        
        if ($model->load(Yii::$app->request->post()) && $model->uniquecheck()) {
        	$model->company_id = Yii::$app->user->identity->input_company_id;
        	$model->sub_activity_name = strip_tags(trim($_POST['SubActivity']['sub_activity_name']));
        	$model->save(false);
        	Yii::$app->session->setFlash('subacts-create');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model, 'activities' => $activities,
            ]);
        }
    }

    /**
     * Updates an existing SubActivity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $channel_id = Activity::CHANNEL;
        $activities = Activity::find()->where(['!=', 'activity_id', $channel_id])->all();
        
        if ($model->load(Yii::$app->request->post()) && $model->uniquecheck()) {
        	$model->save(false);
        	Yii::$app->session->setFlash('subacts-update');
            $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model, 'activities' => $activities,
            ]);
        }
    }

    /**
     * Deletes an existing SubActivity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $sql = Yii::$app->db->createCommand()
    	->update('sub_activity', ['is_deleted' => 1], ['guid' => $id])
    	->execute();
        Yii::$app->session->setFlash('subacts-delete');
        $this->redirect(Url::previous());
    }

    /**
     * Finds the SubActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = SubActivity::find()->where(['guid' => $id])->one();
    	if ($model !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    public function actionDownload()
    {
    	return \Yii::$app->response->sendFile('../subactivity_template.xls');
    
    }
}
