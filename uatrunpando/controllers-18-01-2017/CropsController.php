<?php

namespace app\controllers;

use Yii;
use app\models\Crops;
use app\models\CropsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\helpers\Url;
use app\models\LabelNames;
use app\models\PlanCards;
/**
 * CropsController implements the CRUD actions for Crops model.
 */
class CropsController extends KgController
{
	public function behaviors()
	{
		return [
				'verbs' => [
						'class' => VerbFilter::className(),
						'actions' => [
								//'delete' => ['post'],
						],
				],
		];
	}

	/**
	 * Lists all Crops models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$label_names_display = LabelNames::labelNamesDisplay();
		$label_name = (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop Name');
		$page = Yii::$app->request->get('page');
		$per_page = Yii::$app->request->get('per-page');
		if(!$page && !$per_page) {
			$geturl = Url::remember(['crops/index','page'=>Yii::$app->request->get('page'),'per-page'=>Yii::$app->request->get('per-page') ],'previous');
		}
		$geturl = Url::remember('',null);
		$actioncolumns = $this->accessindexactioncolumns();
		$linkactions = $this->accesslinkactions();
		$searchModel = new CropsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model = new Crops();
		$finalData = array();
		$crops_data = array();
		if (Yii::$app->request->post()) {
			$model->bulkcrops = UploadedFile::getInstance($model, 'bulkcrops');
			$upload = $model->bulkcrops->saveAs(Yii::getAlias('@webroot').'/import/'.$model->bulkcrops);
			$csv = $model->bulkcrops;
			//echo $csv;exit;
			$inputFile = '../web/import/'.$csv;
			try {
				$inputFileType = \PHPExcel_IOFactory::identify($inputFile);
				$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFile);
			} catch (Exception $e) {
				die('bulk crops error');
			}
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$dataColumn = $sheet->getHighestDataColumn();
			$check = 1;
			$row2 = 1;
			$duplicates = array();
			$rowDataheader = $sheet->rangeToArray('A'.$row2.':'.$dataColumn.$row2,NULL,TRUE,FALSE);
			if (strip_tags($rowDataheader[0][1]) != $label_name || $dataColumn != 'B' || strip_tags($rowDataheader[0][0]) == '' || strip_tags($rowDataheader[0][1]) == '' ) {
				$check = 0;
				$flash = Yii::$app->session->setFlash('bulkcrops-wrong-file');
			}
			if ($check == 1) {
				for ($row = 2; $row <= $highestRow; $row++) {
					$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
					if(!array_key_exists(strtolower(trim($rowData[0][1])),$crops_data)) {
						$crops_data[strtolower(trim($rowData[0][1]))] = strtolower(trim($rowData[0][1]));
						if ($rowData[0][1] != '' && !in_array(strtolower(trim($rowData[0][1])), $model->uniqueCropsUpload())) {
							$finalData[$row]['guid'] = Yii::$app->guid->generate();
							$finalData[$row][$label_name] = strip_tags(trim($rowData[0][1]));
							$finalData[$row]['comp_id'] = Yii::$app->user->identity->input_company_id;
							$finalData[$row]['user_id'] = Yii::$app->user->identity->id;
							$finalData[$row]['role_id'] = Yii::$app->user->identity->roleid;
							$finalData[$row]['created_by'] = Yii::$app->user->identity->id;
							$finalData[$row]['updated_by'] = Yii::$app->user->identity->id;
						} else {
							$duplicates[] = strip_tags($rowData[0][1]);
						}
					} else {
						$duplicates[] = strip_tags($rowData[0][1]);
					}
				}
			}
// 			echo '<pre>';print_r($finalData);exit;
			//$sql = "insert into crops (guid, crop_name, comp_id, user_id, created_by, role_id, created_date, updated_by, updated_date) values";
		//	$sql2 = '';
			if ($check == 1) {
				if (!empty($finalData)) {
					$count = count($finalData);
					foreach ($finalData as $value) {
						//$sql2 .= "('".$value['guid']."', '".$value['crop_name']."', '".$value['comp_id']."', '".$value['user_id']."', '".$value['created_by']."', '".$value['role_id']."', NOW(), '".$value['updated_by']."', NOW()),";
						//$sql2 .= '("'.$value['guid'].'", "'.$value['crop_name'].'", "'.$value['comp_id'].'", "'.$value['user_id'].'", "'.$value['created_by'].'","'.$value['role_id'].'", NOW(),"'.$value['updated_by'].'",NOW()),';
						$crops_insert_array[] = array($value['guid'], $value[$label_name], $value['comp_id'], $value['user_id'], $value['created_by'], $value['role_id'],new Expression('NOW()'), $value['updated_by'],new Expression('NOW()'));
					}
					//$sql3 = trim($sql2, ',');
					//$crops = $sql . $sql3;
					//$crops_insert = Yii::$app->db->createCommand($crops)->execute();
					$crops_insert = Yii::$app->db->createCommand()
												->batchInsert('crops', ['guid', 'crop_name', 'comp_id', 'user_id', 'created_by', 'role_id', 'created_date', 'updated_by','updated_date'],
												$crops_insert_array)
												->execute();
					unlink($inputFile);
					$duplicates = array_filter($duplicates);
					if(empty($duplicates)) {
					$flash = Yii::$app->session->setFlash('bulkcrops-success',$count.'  '.(count($label_names_display) > 0 ? $label_names_display['crop_label'] :'crops').' inserted');
					} else {
						$dup = array_unique($duplicates);
						$content = implode(",",$duplicates);
						$flash = Yii::$app->session->setFlash('bulkcrops-duplicate-insert','unique values are inserted successfully and duplicate values are not inserted');
					}
				} else {
					$flash = Yii::$app->session->setFlash('bulkcrops-empty');
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
				'label_names_display' => $label_names_display,
		]);
	}

	/**
	 * Displays a single Crops model.
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
	 * Creates a new Crops model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Crops();
		$label_names_display = LabelNames::labelNamesDisplay();

		if ($model->load(Yii::$app->request->post()) && $model->uniqueCrops()) {
			$model->comp_id = Yii::$app->user->identity->input_company_id;
			$model->user_id = Yii::$app->user->identity->id;
			$model->role_id = Yii::$app->user->identity->roleid;
			$model->crop_name = strip_tags(trim($_POST['Crops']['crop_name']));
			//echo '<pre>';print_r($model->crop_name);exit;
			$model->save(false);
			Yii::$app->session->setFlash('crops-create');
			return $this->redirect(['index']);
		} else {
			return $this->render('create', [
					'model' => $model,
					'label_names_display' => $label_names_display,
			]);
		}
	}

	/**
	 * Updates an existing Crops model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$label_names_display = LabelNames::labelNamesDisplay();

		if ($model->load(Yii::$app->request->post()) && $model->uniqueCrops()) {
			$model->save(false);
			Yii::$app->session->setFlash('crops-update');
			$this->redirect(Url::previous());
		} else {
			return $this->render('update', [
					'model' => $model,
					'label_names_display' => $label_names_display,
			]);
		}
	}

	/**
	 * Deletes an existing Crops model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		//$this->findModel($id)->delete();
		$crop_id = Crops::find()->select(['id'])->where(['guid' => $id])->column();
		$planCropsCount = PlanCards::find()->select('id')->where(['crop_id' => $crop_id[0]])->count();
		//echo '<pre>';print_r($planCrops);exit;
		if($planCropsCount > 0) {
			Yii::$app->session->setFlash('crops-restrict');
		} else {
			$sql = Yii::$app->db->createCommand()
			->update('crops', ['is_deleted' => 1], ['guid' => $id])
			->execute();
			Yii::$app->session->setFlash('crops-delete');
		}
		
		 $this->redirect(Url::previous());
	}

	/**
	 * Finds the Crops model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return Crops the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		$model = Crops::find()->where(['guid' => $id])->one();
		if ($model !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		/* if (($model = Crops::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
    public function actionDownload()
    {
    	$label_names_display = LabelNames::labelNamesDisplay();
    	$label_name = (count($label_names_display) > 0 ? ucfirst($label_names_display['crop_label']) :'Crop Name');
    	$excel2 = \PHPExcel_IOFactory::createReader('Excel5');
    	$excel2 = $excel2->load('../crops_template.xls');
    	//$sheet = $objPHPExcel->getSheet(0);
    	$objWorksheet =  $excel2->setActiveSheetIndex(0);
    	//$excel2->setActiveSheetIndexByName($label_name);
    	$excel2->getActiveSheet()->setCellValue('A1', 'S.No')
    							->setCellValue('B1', $label_name);
    	$styleArray = array(
    			'font'  => array(
    					'bold'  => true,
    					'color' => array('rgb' => '000000'),
    					'size'  => 10,
    					'name'  => 'Verdana'
    			));
    	$excel2->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
    	$excel2->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
    	//$excel2->setActiveSheetIndex(0);
    	if(file_exists($label_name.'.xls')) {
    	chmod('../templates/'.$label_name.'.xls',777);
    	}
    	$objWriter = \PHPExcel_IOFactory::createWriter($excel2, 'Excel5');
    	$objWriter->save('../templates/'.$label_name.'.xls');
    	return \Yii::$app->response->sendFile('../templates/'.$label_name.'.xls');
    
    }
}
