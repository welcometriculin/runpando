<?php

namespace app\controllers;

use Yii;
use app\models\ChannelPartners;
use app\models\RetailerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Users;
use app\models\PlanCards;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\helpers\Url;
use app\models\LabelNames;
/**
 * RetailerController implements the CRUD actions for ChannelPartners model.
 */
class RetailerController extends KgController
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
     * Lists all ChannelPartners models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$label_names_display = LabelNames::labelNamesDisplay();
    	$label_name = (count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Retailer Name');
    	$page = Yii::$app->request->get('page');
    	$per_page = Yii::$app->request->get('per-page');
    	if(!$page && !$per_page) {
    		$geturl = Url::remember(['retailer/index','page'=>Yii::$app->request->get('page'),'per-page'=>Yii::$app->request->get('per-page') ],'previous');
    	}
    	$geturl = Url::remember('',null);
        $searchModel = new RetailerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$model = new ChannelPartners();
		$model->scenario = 'bulkupload';
		$actioncolumns = $this->accessindexactioncolumns();
		$linkactions = $this->accesslinkactions();
		$comp_id = Yii::$app->user->identity->input_company_id;
		$finalData = $temp = array();
		if (Yii::$app->request->post()) {
			$model->bulkretailer = UploadedFile::getInstance($model, 'bulkretailer');
			$model->bulkretailer->saveAs(Yii::getAlias('@webroot').'/import/'.$model->bulkretailer);
			$csv = $model->bulkretailer;
			$inputFile = '../web/import/'.$csv;
			try {
				$inputFileType = \PHPExcel_IOFactory::identify($inputFile);
				$objReader = \PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFile);
			} catch (Exception $e) {
				die('bulk retailer error');
			}
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$dataColumn = $sheet->getHighestDataColumn();
			$check = 1;
			$row2 = 1;
			$rowDataheader = $sheet->rangeToArray('A'.$row2.':'.$highestColumn.$row2,NULL,TRUE,FALSE);
			if (strip_tags($rowDataheader[0][0]) != 'Email Id'  || $highestColumn != 'B' || strip_tags($rowDataheader[0][0]) == '' || strip_tags($rowDataheader[0][1]) == '' ) {
				$check = 0;
				$flash = Yii::$app->session->setFlash('bulkretailers-wrong-file');
			}
			
			if ($check == 1) {
				for ($row = 2; $row <= $highestRow; $row++) {
					$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
					$query = 'SELECT id FROM users WHERE email_address = "'.$rowData[0][0].'" AND is_deleted = 0 AND roleid = 4 AND status = "active" AND input_company_id = '.$comp_id;
					$res_arr = Yii::$app->db->createCommand($query)->queryScalar();
					/* if(empty($res_arr)) {
						$not_exist_email = $rowData[0][0];
						Yii::$app->session->setFlash('bulkemail-not-exist',"'$not_exist_email'".' is not a field force email');
						break;
					} */
				
					if(!array_key_exists(strtolower(trim($rowData[0][0])).'_'.strtolower(trim($rowData[0][1])),$temp)) {
					
						$temp[strtolower(trim($rowData[0][0])).'_'.strtolower(trim($rowData[0][1]))] = true;
						//echo $s = in_array(strtolower(trim($rowData[0][1])), $model->uniqueRetailersUpload($rowData[0][0]));exit;
						if ($rowData[0][0] != '' && $rowData[0][1] != '' && !in_array(strtolower(trim($rowData[0][1])), $model->uniqueRetailersUpload($rowData[0][0])) && !empty($res_arr)) {
							$finalData[$row]['guid'] = Yii::$app->guid->generate();
							$finalData[$row]['email'] = strip_tags($rowData[0][0]);
							$finalData[$row][$label_name] = trim(strip_tags($rowData[0][1]));
							$finalData[$row]['comp_id'] = Yii::$app->user->identity->input_company_id;
							$finalData[$row]['user_id'] = $res_arr;
							$finalData[$row]['role_id'] = Yii::$app->user->identity->roleid;
							$finalData[$row]['created_by'] = Yii::$app->user->identity->id;
							$finalData[$row]['updated_by'] = Yii::$app->user->identity->id;
							//$emails_village_list[$rowData[0][0]][] = $rowData[0][1];
							/* 	if ($finalData[$row]['village_name'] == '') {
							 $check = 0;
							 $flash = Yii::$app->session->setFlash('bulkvillages-fields-empty');
							 break;
							} */
							/* if (in_array(strtolower($finalData[$row]['village_name']), $model->uniqueVillagesUpload($finalData[$row]['email']))) {
							 $duplicate_data['email'] = $rowData[0][0];
							 $duplicate_data['village_name'] = $rowData[0][1];
							 $check = 0;
							 $user_email_id = $finalData[$row]['email'];
							 $user_village_id = $finalData[$row]['village_name'];
							 $flash = Yii::$app->session->setFlash('bulkvillages-exist','Duplicate village exists against a '."'$user_email_id.' Please check the attached file");
							 break;
							} */
							
						} else {
						
							$duplicate_list[$rowData[0][0]][] = $rowData[0][1];
							//echo '<pre>';print_r($duplicate_list);exit;
						}
					} else {
						$duplicate_list[$rowData[0][0]][] = $rowData[0][1];
					}	
				}
			}
			//$sql = "insert into channel_partners (guid, channel_partner_name, comp_id, user_id, created_by, role_id, created_date, updated_by, updated_date) values";
			//$sql2 = '';
			if ($check == 1) {
				if (!empty($finalData)) {
					$count = count($finalData);
					foreach ($finalData as $value) {
						//$sql2 .= "('".$value['guid']."', '".$value['channel_partner_name']."', '".$value['comp_id']."', '".$value['user_id']."', '".$value['created_by']."', '".$value['role_id']."', NOW(), '".$value['updated_by']."', NOW()),";
						//$sql2 .= '("'.$value['guid'].'", "'.$value['channel_partner_name'].'", "'.$value['comp_id'].'", "'.$value['user_id'].'", "'.$value['created_by'].'", "'.$value['role_id'].'", NOW(), "'.$value['updated_by'].'", NOW()),';
						$bulk_retailers[] = array($value['guid'],$value[$label_name], $value['comp_id'], $value['user_id'], $value['created_by'], $value['role_id'], new Expression('NOW()'),$value['updated_by'], new Expression('NOW()') );
						
						
						
					}
					//$sql3 = trim($sql2, ',');
					//$retailers = $sql . $sql3;
					//$crops_insert = Yii::$app->db->createCommand($retailers)->execute();
					$reatilers_insert = Yii::$app->db->createCommand()
									->batchInsert('channel_partners', ['guid', 'channel_partner_name', 'comp_id', 'user_id', 'created_by', 'role_id', 'created_date', 'updated_by', 'updated_date'],
										$bulk_retailers)
									->execute();
					unlink($inputFile);
					if(empty($duplicate_list)) {
						$flash = Yii::$app->session->setFlash('bulkretailers-success',$count.'  retailers mapped successfully');
					} else {
						$flash = Yii::$app->session->setFlash('bulkretailers-duplicate-insert','unique values are inserted successfully and duplicate are not inserted');
					}
				}else {
					$flash = Yii::$app->session->setFlash('bulkretailers-empty-data');
				}
			}
			return $this->refresh();
		}
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'actioncolumns'=> $actioncolumns,
        	'linkactions' => $linkactions,
        	'model'			=>	$model,
        	'label_names_display' => $label_names_display,	
        ]);
    }

    /**
     * Displays a single ChannelPartners model.
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
     * Creates a new ChannelPartners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChannelPartners();
        $manager_list = Users::managerList();
        $label_names_display = LabelNames::labelNamesDisplay();
        if ($model->load(Yii::$app->request->post()) && $model->uniqueRetailer()) {
        	$model->comp_id = Yii::$app->user->identity->input_company_id;
        	$model->role_id = Yii::$app->user->identity->roleid;
        	$model->channel_partner_name = strip_tags(trim($_POST['ChannelPartners']['channel_partner_name']));
        	if($model->save(false)) {
        		Yii::$app->session->setFlash('retailer-create');
        	} else {
        		Yii::$app->session->setFlash('retailers-create-fail');
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
     * Updates an existing ChannelPartners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
   		 $model = $this->findModel($id);
   		 
		$manager_list = Users::managerList();
		$fflist = Users::feildList();
		$label_names_display = LabelNames::labelNamesDisplay();
		if ($model->load(Yii::$app->request->post())) {
			if($model->save(false)){
				Yii::$app->session->setFlash('retailer-update');
				$this->redirect(Url::previous());
			} else {
				Yii::$app->session->setFlash('retailer-update-fail');
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
     * Deletes an existing ChannelPartners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$channel_name = ChannelPartners::find()->select('channel_partner_name')->where(['guid' => $id])->asArray()->one();
    	$channel_name_check = Plancards::find()->select('count(*)')->where(['channel_partner' =>$channel_name['channel_partner_name']])->count();
    	if($channel_name_check == 0) {
    		$update = Yii::$app->db->createCommand()
    		->update('channel_partners', ['is_deleted' => 1], 'guid ="'. $id.'"')
    		->execute();
    		if($update) {
    			Yii::$app->session->setFlash('channel-partners-delete');
    		} else {
    			Yii::$app->session->setFlash('channel-partners-fail');
    		}
    	} else {
    		Yii::$app->session->setFlash('channel-partners-plancard');
    	}
    	return $this->redirect(['index']);
    }

    /**
     * Finds the ChannelPartners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelPartners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = ChannelPartners::find()->where(['guid' => $id])->one();
    	if ($model !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
        /* if (($model = ChannelPartners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
    public function actionDownload()
    {
    	$label_names_display = LabelNames::labelNamesDisplay();
    	$label_name = (count($label_names_display) > 0 ? ucfirst($label_names_display['partner_label']) :'Retailer Name');
    	$excel2 = \PHPExcel_IOFactory::createReader('Excel5');
    	$excel2 = $excel2->load('../retailers.xls');
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
    	//return \Yii::$app->response->sendFile('../retailers.xls');
    
    }
}
