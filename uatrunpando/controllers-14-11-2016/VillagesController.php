<?php

namespace app\controllers;

use Yii;
use app\models\Villages;
use app\models\VillagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Users;
use app\models\PlanCards;
use yii\web\UploadedFile;
use app\models\VillagesMaster;
use yii\db\Expression;
use yii\helpers\Url;
use app\models\LabelNames;
/**
 * VillagesController implements the CRUD actions for Villages model.
 */
class VillagesController extends KgController
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
	 * Lists all Villages models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$label_names_display = LabelNames::labelNamesDisplay();
		$label_name = (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village Name');
		$page = Yii::$app->request->get('page');
		$per_page = Yii::$app->request->get('per-page');
		if(!$page && !$per_page) {
			$geturl = Url::remember(['villages/index','page'=>Yii::$app->request->get('page'),'per-page'=>Yii::$app->request->get('per-page') ],'previous');
		}
		$geturl = Url::remember('',null);
		$searchModel = new VillagesSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$actioncolumns = $this->accessindexactioncolumns();
		$linkactions = $this->accesslinkactions();
		$model = new Villages();
		$emails_list = $matched_villages_array = array();
		$villages_insertion = $villages_master_insertion = '';
		$count_vill = 0;
		$model->scenario = 'bulkupload';
		$comp_id = Yii::$app->user->identity->input_company_id;
		$finalData = $temp = $user_id = $villages_table = array();
		if (Yii::$app->request->post()) {
			$model->bulkvillages = UploadedFile::getInstance($model, 'bulkvillages');
			$model->bulkvillages->saveAs(Yii::getAlias('@webroot').'/import/'.$model->bulkvillages);
			$csv = $model->bulkvillages;
			$inputFile = '../web/import/'.$csv;
			try {
				$inputFileType = \PHPExcel_IOFactory::identify($inputFile);
				$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFile);
			} catch (Exception $e) {
				die('bulk villages error');
			}
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$dataColumn = $sheet->getHighestDataColumn();
			$check = 1;
			$row2 = 1;
			$rowDataheader = $sheet->rangeToArray('A'.$row2.':'.$highestColumn.$row2,NULL,TRUE,FALSE);
// 			echo $rowDataheader[0][1];exit;
			if (strip_tags($rowDataheader[0][0]) != 'Email Id' || strip_tags($rowDataheader[0][1]) != $label_name || $highestColumn != 'B' || strip_tags($rowDataheader[0][0]) == '' || strip_tags($rowDataheader[0][1]) == '' ) {
				$check = 0;
				$flash = Yii::$app->session->setFlash('bulkvillages-wrong-file');
			}
			if ($check == 1) {
				for ($row = 2; $row <= $highestRow; $row++) {
					$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
					if(trim($rowData[0][0]) != '') {
						$query = "SELECT id FROM users WHERE email_address = '".trim($rowData[0][0])."' AND is_deleted = 0 AND roleid = 4 AND status = 'active' AND input_company_id = $comp_id";
						$res_arr = Yii::$app->db->createCommand($query)->queryScalar();
						if(empty($res_arr)) {
							$not_exist_email = $rowData[0][0];
							Yii::$app->session->setFlash('bulkemail-not-exist',"'$not_exist_email'".'is not a field force Email Id');
							goto a;
						}
					}
					if(!array_key_exists(strtolower(trim($rowData[0][0])).'_'.strtolower(trim($rowData[0][1])),$temp)) {
						$temp[strtolower(trim($rowData[0][0])).'_'.strtolower(trim($rowData[0][1]))] = true;
						if ( $rowData[0][0] != '' && $rowData[0][1] != '' && !in_array(strtolower(trim($rowData[0][1])), $model->uniqueVillagesUpload(trim($rowData[0][0])))) {
							$villages_list[] = strtolower($rowData[0][1]);
							//$village_email_list[$rowData[0][0]][] = $rowData[0][1];
							$finalData[$row]['guid'] = Yii::$app->guid->generate();
							$finalData[$row]['email'] = strtolower(strip_tags(trim($rowData[0][0])));
							$finalData[$row][$label_name] = strip_tags(trim($rowData[0][1]));
							$finalData[$row]['comp_id'] = Yii::$app->user->identity->input_company_id;
							$finalData[$row]['user_id'] = $res_arr;
							$finalData[$row]['role_id'] = Yii::$app->user->identity->roleid;
							$finalData[$row]['created_by'] = Yii::$app->user->identity->id;
							$finalData[$row]['updated_by'] = Yii::$app->user->identity->id;
							$user_id[] = $res_arr;
							$villages_guid [] = Yii::$app->guid->generate();
							$email_villages_list[strip_tags(trim($rowData[0][1]))][] = strtolower(strip_tags(trim($rowData[0][0])));
						} else {
							//$duplicate_list[$rowData[0][0]][] = $rowData[0][1];
							$duplicate_list[$rowData[0][0]] = $rowData[0][1];
						}
					} else {
						//$duplicate_list[$rowData[0][0]][] = $rowData[0][1];
						$duplicate_list[$rowData[0][0]] = $rowData[0][1];
					}
				}
			}
			if(!empty($finalData)) {
				$village_check = VillagesMaster::find()->select('village_id,village_name')->where(['village_name' => $villages_list])->asArray()->all();
				if(!empty($village_check)) {
					foreach($village_check as $villagename)  {
						$vill_name[] = strtolower($villagename['village_name']);
						$village_ids[$villagename['village_id']] = strtolower($villagename['village_name']);
					}
				}
				// 				echo 'dsad';echo '<pre>';print_r($email_villages_list);exit;
				//total new villages for all users
				if(empty($village_check)) {
					foreach($email_villages_list as $key => $data) {
						$model = new VillagesMaster();
						$guid = Yii::$app->guid->generate();
						$village_name = $key;
						$created_by = Yii::$app->user->identity->id;
						$updated_by = Yii::$app->user->identity->id;
						$created_date =  new Expression('NOW()');
						$updated_date =  new Expression('NOW()');
						$villages[] = $village_name;
						$vull = implode(',',$villages);
						$villages_array [] = array($guid,$village_name,$created_by,$updated_by,$created_date,$updated_date);
						//$villages_insertion .= "('".$guid."', '".$village_name."', '".$created_by."', '".$updated_by."', NOW(), NOW()),";
						$villages_insertion .= '("'.$guid.'", "'.$village_name.'", "'.$created_by.'", "'.$updated_by.'", NOW(), NOW()),';
						
					
					
					}
					$villages_query = "insert into villages_master (guid, village_name, created_by, updated_by, created_date, updated_date) values";
					//$excute_query = Yii::$app->db->createCommand()->batchInsert('villages_master', ['guid', 'village_name', 'created_by', 'updated_by', 'created_date', 'updated_date'], $villages_array)->execute();
					$villages_trim_list = trim($villages_insertion, ',');
					$villages_exceute_string = $villages_query.$villages_trim_list.'ON DUPLICATE KEY
							UPDATE village_name = VALUES(village_name)' ;
					$excute_query = Yii::$app->db->createCommand($villages_exceute_string)->execute();
					//$last_input_user_id = Yii::$app->db->getLastInsertID();

					if(!empty($email_villages_list)) {
						foreach($email_villages_list as $key => $data) {
							foreach($data as $inner_data) {
								$comp_id = Yii::$app->user->identity->input_company_id;
								$un_id = Yii::$app->user->identity->id;
								$villages_guid = Yii::$app->guid->generate();
								$role_id = Yii::$app->user->identity->roleid;
								$date = new Expression('NOW()');
								$query = 'SELECT id FROM users WHERE email_address = "'.$inner_data.'" AND is_deleted = 0 AND roleid = 4  AND input_company_id = "'.$comp_id.'"';
								$res_arr = Yii::$app->db->createCommand($query)->queryScalar();
								$village_id_query =  'SELECT village_id FROM villages_master WHERE village_name = "'.$key.'"';
								$village_id = Yii::$app->db->createCommand($village_id_query)->queryScalar();
								$matched_villages_array[] = array($villages_guid,$village_id,$comp_id,$res_arr,$role_id,$un_id,$date,$un_id,$date);
							}

						}
					}
					$cnt_villages = count($villages_array);
					$excute_query2 = Yii::$app->db->createCommand()->batchInsert('villages', ['guid', 'village_id', 'comp_id', 'user_id', 'role_id','created_by', 'created_date', 'updated_by', 'updated_date'], $matched_villages_array)->execute();
					if(empty($duplicate_list)) {
						$flash = Yii::$app->session->setFlash('bulkvillages-success',$cnt_villages.'  '.(count($label_names_display) > 0 ? $label_names_display['village_label'] :'villages').' mapped successfully');
					} else {
						$flash = Yii::$app->session->setFlash('bulkvillages-duplicate-insert','unique values are inserted successfully and duplicate are not inserted');
					}

				} else {
					// if mix i.e existed villages and new villages
					/* foreach($villages_list as $vil) {
					if(in_array($vil,$vill_name)) {
					$existed[] = $vil;

					} else {
					$not_existed[] = $vil;
					}
					} */
					// 					echo '<pre>';print_r($email_villages_list);exit;
					foreach($email_villages_list as $key1 =>$list) {
						foreach($list as $l) {
							if(in_array(strtolower($key1),$vill_name)) {
								$vill_guid = Yii::$app->guid->generate();
								$query5 = 'SELECT id FROM users WHERE email_address = "'.$l.'" AND is_deleted = 0 AND roleid = 4  AND input_company_id = "'.$comp_id.'"';
								$us_id = Yii::$app->db->createCommand($query5)->queryScalar();
								$vill_id_query =  'SELECT village_id FROM villages_master WHERE village_name = "'.$key1.'"';
								$vill_id = Yii::$app->db->createCommand($vill_id_query)->queryScalar();
								$cr_by = Yii::$app->user->identity->id;
								$cr_date =  new Expression('NOW()');
								$role_id = Yii::$app->user->identity->roleid;
								$villages_insert[] = array($vill_guid,$vill_id,$comp_id,$us_id,$role_id,$cr_by,$cr_date,$cr_by,$cr_date);

							} else {
								$guid4 = Yii::$app->guid->generate();
								$village_name = $key1;
								$created_user= Yii::$app->user->identity->id;
								$villages_master_insert[] = array('village_name' =>$key1,'emailid'=> $l);
								//$villages_master_insertion .= "('".$guid4."', '".$village_name."', '".$created_user."', '".$created_user."', NOW(), NOW()),";
								$villages_master_insertion .= '("'.$guid4.'", "'.$village_name.'", "'.$created_user.'", "'.$created_user.'", NOW(), NOW()),';
								
							
							}
						}
					}
					if(!empty($villages_insert)) {
						$excute5 = Yii::$app->db->createCommand()->batchInsert('villages', ['guid', 'village_id', 'comp_id', 'user_id', 'role_id','created_by', 'created_date', 'updated_by', 'updated_date'], $villages_insert)->execute();
						$count_vill = count($villages_insert) +  $count_vill;

					}
					//villages master insertion and village tabel
					if($villages_master_insertion != '') {
						$villages_query5 = "insert into villages_master (guid, village_name, created_by, updated_by, created_date, updated_date) values";
						$villages_multi_trim_list1 = trim($villages_master_insertion, ',');
						$villages_exceute_string = $villages_query5.$villages_multi_trim_list1.'ON DUPLICATE KEY
								UPDATE village_name = VALUES(village_name)' ;
						$excute_query6 = Yii::$app->db->createCommand($villages_exceute_string)->execute();
					}
					//	$excute_query6 = Yii::$app->db->createCommand()->batchInsert('villages_master', ['guid', 'village_name', 'created_by', 'updated_by', 'created_date', 'updated_date'], $villages_master_insert)->execute();
						
					if(!empty($villages_master_insert)) {
						foreach($villages_master_insert as $rel) {
							$comp_id = Yii::$app->user->identity->input_company_id;
							$un_id = Yii::$app->user->identity->id;
							$villages_guid = Yii::$app->guid->generate();
							$role_id = Yii::$app->user->identity->roleid;
							$date3 = new Expression('NOW()');
							$emailid = $rel['emailid'];
							$city_name = $rel['village_name'];
							$query = 'SELECT id FROM users WHERE email_address = "'.$emailid.'" AND is_deleted = 0 AND roleid = 4  AND input_company_id = "'.$comp_id.'"';
							$res_arr = Yii::$app->db->createCommand($query)->queryScalar();
							$village_id_query =  'SELECT village_id FROM villages_master WHERE village_name = "'.$city_name.'"';
							$village_id = Yii::$app->db->createCommand($village_id_query)->queryScalar();
							$mat_villages_array[] = array($villages_guid,$village_id,$comp_id,$res_arr,$role_id,$un_id,$date3,$un_id,$date3);
							$cnt_master = count($mat_villages_array);

						}
					}
						
					if(!empty($mat_villages_array)) {
						$excute7 = Yii::$app->db->createCommand()->batchInsert('villages', ['guid', 'village_id', 'comp_id', 'user_id', 'role_id','created_by', 'created_date', 'updated_by', 'updated_date'], $mat_villages_array)->execute();
						$count_vill = count($mat_villages_array) +  $count_vill;
					}
					if(empty($duplicate_list)) {
						$flash = Yii::$app->session->setFlash('bulkvillages-success',$count_vill.'  '.(count($label_names_display) > 0 ? $label_names_display['village_label'] :'villages').' mapped successfully');
					} else {
						$flash = Yii::$app->session->setFlash('bulkvillages-duplicate-insert','unique values are inserted successfully and duplicate are not inserted');
					}
				}
			}  else {
				$flash = Yii::$app->session->setFlash('bulkvillages-empty-data');
			}
			return $this->refresh();
		}
		a:
		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'actioncolumns'=> $actioncolumns,
				'linkactions' => $linkactions,
				'model'     => $model,
				'label_names_display' => $label_names_display,
		]);
	}

	/**
	 * Displays a single Villages model.
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
	 * Creates a new Villages model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Villages();
		$master_model = new VillagesMaster();
		$manager_list = Users::managerList();
		$label_names_display = LabelNames::labelNamesDisplay();
		$model->scenario = 'villagescreate';
		if ($model->load(Yii::$app->request->post()) && $model->uniqueVillage()) {
			$village_name = strip_tags(trim($_POST['Villages']['village_name']));
			$model->comp_id = Yii::$app->user->identity->input_company_id;
			$model->role_id = Yii::$app->user->identity->roleid;
			$get_id = VillagesMaster::find()->select('village_id,village_name')->where(['village_name' => $village_name]);
			$villages = $get_id->asArray()->one();
			if($get_id->count() > 0) {
				$model->village_id = $villages['village_id'];
				$model->village_name = NULL;
				$rel_model = $model->save(false);
			} else {
				$master_model->village_name = $village_name;
				$mas_model = $master_model->save(false);
				$model->village_id = Yii::$app->db->getLastInsertID();
				$model->village_name = NULL;
				$rel_model = $model->save(false);
			}
			if($rel_model) {
				Yii::$app->session->setFlash('villages-create');
			} else {
				Yii::$app->session->setFlash('villages-create-fail');
			}
			return $this->redirect('index');
		} else {
			return $this->render('create', [
					'model' => $model,
					'mmlist' => $manager_list,
					'label_names_display' => $label_names_display,
			]);
		}
	}

	/**
	 * Updates an existing Villages model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$label_names_display = LabelNames::labelNamesDisplay();

		$manager_list = Users::managerList();
		$fflist = Users::feildList();
		$master_model = new VillagesMaster();
		if ($model->load(Yii::$app->request->post())) {
			$village_name = $_POST['Villages']['village_name'];
			$villages_exist_check = VillagesMaster::find()->select('village_id,village_name')
															->where(['village_name' => $village_name])
															->asArray()
															->one();
			$villages_exist_check_count = count($villages_exist_check);
			if($villages_exist_check_count > 0) {
				$villages_exist_id = $villages_exist_check['village_id'];
				$query = Yii::$app->db->createCommand('UPDATE villages
					set village_id ="'.$villages_exist_id.'"
					WHERE guid="'.$id.'"')->execute();
			} else {
			$query = Yii::$app->db->createCommand('UPDATE villages_master vm
					JOIN villages v on v.village_id = vm.village_id
					set vm.village_name ="'.$village_name.'"
					WHERE v.guid="'.$id.'"')->execute();
			}
			if($query){
				Yii::$app->session->setFlash('villages-update');
				$this->redirect(Url::previous());
			} else {
				Yii::$app->session->setFlash('villages-update-fail');
				$this->redirect(Url::previous());
			}
		} else {
			return $this->render('update', [
					'model' => $model,
					'mmlist' => $manager_list,
					'fflist' => $fflist,
					'label_names_display' => $label_names_display,
			]);
		}
	}

	/**
	 * Deletes an existing Villages model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$village_name = Villages::find()->select('village_id,user_id')->where(['guid' => $id])->asArray()->one();
		$village_name_check = Plancards::find()->select('count(*)')->where(['village_id' =>$village_name['village_id'],'assign_to' =>$village_name['user_id'] ])->count();
		if($village_name_check == 0) {
			$update = Yii::$app->db->createCommand()
			->update('villages', ['is_deleted' => 1], 'guid ="'. $id.'"')
			->execute();
			if($update) {
				Yii::$app->session->setFlash('villages-delete');
			} else {
				Yii::$app->session->setFlash('villages-delete-fail');
			}
		} else {
			Yii::$app->session->setFlash('villages-plancard');
		}
		$this->redirect(Url::previous());
	}

	/**
	 * Finds the Villages model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Villages the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		/* 	$model = Villages::find()
		 ->joinWith(['villages_master'])
		 ->where(['guid' => $id])->one(); */
		$model = Villages::find()
		->select('v.village_id,vm.village_name,v.user_id')
		->from('villages v')
		->innerJoin('villages_master vm','vm.village_id = v.village_id')
		->where(['v.guid' => $id])->one();
		if ($model !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		/*  if (($model = Villages::findOne($id)) !== null) {
		 return $model;
		 } else {
		 throw new NotFoundHttpException('The requested page does not exist.');
		 } */
	}
	public function actionDownload()
	{
		$label_names_display = LabelNames::labelNamesDisplay();
		$label_name = (count($label_names_display) > 0 ? ucfirst($label_names_display['village_label']) :'Village Name');
		$excel2 = \PHPExcel_IOFactory::createReader('Excel5');
		$excel2 = $excel2->load('../villages.xls');
		//$sheet = $objPHPExcel->getSheet(0);
		$objWorksheet =  $excel2->setActiveSheetIndex(0);
		//$excel2->setActiveSheetIndexByName($label_name);
		$excel2->getActiveSheet()->setCellValue('A1', 'Email Id')
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
// 		return \Yii::$app->response->sendFile('../villages.xls');

	}
	public function actionFflist()
	{
		if(isset($_REQUEST)) {
			$flag = 'create';
			$mm_id = $_REQUEST['mm_id'];
			if ($mm_id != '') {
				$manager_list = Users::ffList($mm_id, $flag);
				//$products_list = Products::productList($assign_to, $flag);
				//$crops_list = Crops::cropList($assign_to, $flag);
				$response = array($manager_list);
			} else {
				$response = 0;
			}
			return json_encode($response);
		}
	}

	public function actionRepotmanager()
	{
		if(isset($_REQUEST)) {
			$ff_id = $_REQUEST['ff_id'];
			if ($ff_id != '') {
				$manager_list = Users::reportManager($ff_id);
				//$products_list = Products::productList($assign_to, $flag);
				//$crops_list = Crops::cropList($assign_to, $flag);
				return $manager_list;
			}
		}
	}
}
