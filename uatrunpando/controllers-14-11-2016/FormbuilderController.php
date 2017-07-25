<?php

namespace app\controllers;

use Yii;
use app\models\FormBuilder;
use app\models\FormBuilderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\LabelNames;
use app\models\InputCompanies;
use app\models\FormBuilderActivities;
use app\models\FormValue;
use yii\db\Expression;
/**
 * FormbuilderController implements the CRUD actions for FormBuilder model.
 */
class FormbuilderController extends KgController
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
	 * Lists all FormBuilder models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new FormBuilderSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single FormBuilder model.
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
	 * Creates a new FormBuilder model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{

		$model = new FormBuilder();
		$formActivity = new FormBuilderActivities();
		$formValue = new FormValue();
		$label_names = new LabelNames();
		$companyList = InputCompanies::companyList();
		$bulk_steps = array();
		$batchinsert = array();
		$valuesIndex = array();
		 
		if ($model->load(Yii::$app->request->post())) {
			$user_id = Yii::$app->user->identity->id;
			$expression = new Expression('NOW()');
//   			echo '<pre>';print_r(Yii::$app->request->post());exit;
			$form_data = Yii::$app->request->post('FormBuilder');
			if ($form_data['step_1_field1_require'] == 0) {
				unset($form_data['step_1_field1_require'], $form_data['step_1_field1_stepno'], $form_data['step_1_field1_no_of_images']);
			}
			if ($form_data['step_2_field1_require'] == 0) {
				unset($form_data['step_2_field1_require'], $form_data['step_2_field1_stepno'], $form_data['step_2_field1_no_of_images']);
			}
			if ($form_data['step_3_require'] == 0) {
				unset($form_data['step_3_require']);
			} else if ($form_data['step_3_require'] == 1) {
				unset($form_data['step_3_require']);
			}
			if ($form_data['step_4_field1_require'] == 0) {
				unset($form_data['step_4_field1_require'], $form_data['step_4_field1_stepno'], $form_data['step_4_field1_no_of_images']);
			}
			if ($form_data['step_5_field1_require'] == 0) {
				unset($form_data['step_5_field1_require'], $form_data['step_5_field1_stepno'], $form_data['step_5_field1_no_of_images'],$form_data['step_5_field1_no_chars']);
			}
			
			//echo '<pre>';print_r($form_data);exit;
			$company_id = $form_data['company_id'];
			$activity_id = $form_data['activity'];
			unset($form_data['company_id'],$form_data['activity']);
			//echo '<pre>';print_r($form_data);exit;
			/* $delete = "DELETE fv. * , fb. * , fba. *
						FROM form_builder fb
						LEFT JOIN form_value fv ON fv.form_builder_id = fb.form_builder_id
						JOIN form_builder_activities fba ON fba.form_builder_activity_id = fb.form_builder_activity_id
						WHERE fba.activity_id = $activity_id 
						AND fba.company_id = $company_id"; */
			$delete = "DELETE fv. * , fb. *
			FROM form_builder_activities fba
			JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
			LEFT JOIN form_value fv ON fv.form_builder_id = fb.form_builder_id
			WHERE fba.activity_id = $activity_id
			AND fba.company_id = $company_id";
			Yii::$app->db->createCommand($delete)->execute();
			if(!empty($form_data)) {
				foreach ($form_data as $key => $data) {
					$steps_array = explode('_',$key);
					//echo '<pre>';print_r($steps_array['2']);exit;
					if($steps_array['1'] == 1) {
						$bulk_steps['step1'][$steps_array['2']][] = $data;
					} else if($steps_array['1'] == 2) {
						$bulk_steps['step2'][$steps_array['2']][] = $data;
					} else if($steps_array['1'] == 3) {
						$bulk_steps['step3'][$steps_array['2']][] = $data;
					} else if($steps_array['1'] == 4) {
						$bulk_steps['step4'][$steps_array['2']][] = $data;
					} else if($steps_array['1'] == 5) {
						$bulk_steps['step5'][$steps_array['2']][] = $data;
					}
				}
			}
// 			echo '<pre>';print_r($bulk_steps);exit;
			if (!empty($bulk_steps)) {
				foreach($bulk_steps as $steps) {
					foreach($steps as $array) {
						//echo '<pre>';print_r($array);exit;
						$batchinsert[] = $array;
					}
				}
			}
			$formActivity->activity_id = $activity_id;
			$formActivity->company_id = $company_id;
			$check = Yii::$app->db->createCommand("select form_builder_activity_id from form_builder_activities where company_id = :company_id and activity_id = :activity_id")
								->bindValues([':company_id' => $company_id, ':activity_id' => $activity_id])
								->queryOne();
			if (!empty($check)) {
				$formBulderActvityid = $check['form_builder_activity_id'];
				Yii::$app->session->setFlash('dynamic-form-exist');
			} else {
				$formActvitySave = $formActivity->save(false);
				$formBulderActvityid = Yii::$app->db->getLastInsertID();
				Yii::$app->session->setFlash('dynamic-form-not-exist');
			}
			
// 			$formActivity->activity_id = $activity_id;
// 			$formActivity->company_id = $company_id;
// 			$formActvitySave = $formActivity->save(false);
// 			$formBulderActvityid = Yii::$app->db->getLastInsertID();
// 			echo '<pre>';print_r($batchinsert);exit;
			if(!empty($batchinsert)) {
				foreach($batchinsert as $key => $formarray)
				{
					array_unshift($formarray,$formBulderActvityid);
					array_push($formarray, $user_id, $user_id,$expression,$expression);
					$batchinsert_array[] = $formarray;
				}
// 				echo '<pre>';print_r($batchinsert_array);exit;
				$formBatchInsert = Yii::$app->db->createCommand()->batchInsert('form_builder', ['form_builder_activity_id', 'step', 'require','label','mandatory','data_type','no_of_chars','validation_type', 'no_of_images', 'created_by','updated_by','created_date','updated_date'], $batchinsert_array)->execute();
				Yii::$app->session->setFlash('dynamic-form-save');
			}
			//echo '<pre>';print_r($batchinsert_array);exit;
			//$formBatchInsert = Yii::$app->db->createCommand()->batchInsert('form_builder', ['form_builder_activity_id', 'step', 'require','mandatory','label','data_type','validation_type','created_by','updated_by','created_date','updated_date'], $batchinsert_array)->execute();
			//exit;
			if(!empty($batchinsert)) {
				foreach ($batchinsert as $k => $v){
					if($v[4] == "radio"){
						$valuesIndex[] = array('index' => $k,'stepno' => $v[0]);
					}else if($v[4] == "checkbox"){
						$valuesIndex[] = array('index' => $k,'stepno' => $v[0]);
					} else if ($v[4] == "selectbox" && $v[0] != 1){
						$valuesIndex[] = array('index' => $k,'stepno' => $v[0]);
					}
				}
			}
			$totalFormData = Yii::$app->request->post();
			unset($totalFormData['FormBuilder'],$totalFormData['_csrf']);
			$filter_box_data = array();
			if (!empty($totalFormData)) {
				foreach ($totalFormData as $boxes_data) {
					$boxes_data = array_filter($boxes_data);
					if (!empty($boxes_data)) {
						$filter_box_data[] = $boxes_data;
					}
				}
				$totalFormData = $filter_box_data;
			}

// 			print_r($totalFormData);exit;
// 			echo '<pre>';print_r(array_filter($totalFormData));exit;
			$formBulderlastid = Yii::$app->db->getLastInsertID();
			$formbuilderAcId = array();
            if(!empty($valuesIndex)) {
            	foreach($valuesIndex as $index) {
            		$formbuilderAcId[] = $index['index'] + $formBulderlastid;
            	}    
            	$i =0;
            	if(!empty($totalFormData)) {
            		foreach($totalFormData as $values) {
            			array_unshift($values,$formbuilderAcId[$i]);
            			$bulkValuesInsert[] = $values;
            			$i++;
            			}
            	}
//             	echo '<pre>';print_r($bulkValuesInsert);exit;
            	$bulkValuesInsertNew = array();
            	$index= 0;
            	if(!empty($bulkValuesInsert)) {
            	foreach($bulkValuesInsert as $key => $val){
            		$id = $val[0];
            		unset($val[0]);
            		foreach($val as $key1 => $val1){
            			$bulkValuesInsertNew[$index][] = $id;
            			$bulkValuesInsertNew[$index][] = $val1;
            			$index++;
            		}
            	}
            	}
            	//echo '<pre>';print_r($bulkValuesInsertNew);exit;
            	 
            	if(!empty($bulkValuesInsertNew)) {
            		foreach($bulkValuesInsertNew as $key1 => $formarray1)
            		{
            			array_push($formarray1, $user_id, $user_id,$expression,$expression);
            			$batchinsert_array2[] = $formarray1;
            		}
//             		echo '<pre>';print_r($batchinsert_array2);exit;
            		$formBatchInsert2 = Yii::$app->db->createCommand()->batchInsert('form_value', ['form_builder_id','value','created_by','updated_by','created_date','updated_date'], $batchinsert_array2)->execute();
            		
            	}
//             	echo '<pre>';print_r($batchinsert_array2);exit;
            	 
            	     
            }
			return $this->redirect(['create']);
		} else {
			return $this->render('create', [
					'model' => $model,
					'label_names' => $label_names,
					'companyList' => $companyList,
			]);
		}
	}

	/**
	 * Updates an existing FormBuilder model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->form_builder_id]);
		} else {
			return $this->render('update', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing FormBuilder model.
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
	 * Finds the FormBuilder model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return FormBuilder the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = FormBuilder::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionLabelnamescreate()
	{
		$label_names = new LabelNames();
		 
		if ($label_names->load(Yii::$app->request->post())) {
			$company_id = $label_names->company_id;
			$crop_label = $label_names->crop_label;
			$product_label = $label_names->product_label;
			$village_label = $label_names->village_label;
			$partner_label = $label_names->partner_label;
			$check = Yii::$app->db->createCommand("select label_names_id from label_names where company_id = :company_id")
			->bindValue(':company_id', $company_id)
			->queryAll();
			if (count($check) == 0) {
				$label_names->save(false);
			} else {
				Yii::$app->db->createCommand()->update('label_names', ['crop_label' => $crop_label, 'product_label' => $product_label, 'village_label' => $village_label, 'partner_label' => $partner_label ], 'company_id = :company_id')
				->bindValue(':company_id', $company_id)
				->execute();
			}
			Yii::$app->session->setFlash('label-names-create', 'Label Names created successfully.');
			return $this->redirect(['create']);
		} else {
			return $this->render('create', [
					'label_names' => $label_names,
			]);
		}
	}
	//ajax for label names list
	public function actionLabelnameslist()
	{
		$result = array();
		if (isset($_REQUEST)) {
			$sql = Yii::$app->db->createCommand("select * from label_names where company_id = :company_id")
			->bindValue(':company_id', $_REQUEST['company_id'])
			->queryOne();
			if (!empty($sql)) {
				$result = array('crop_label' => $sql['crop_label'], 'product_label' => $sql['product_label'], 'village_label' => $sql['village_label'], 'partner_label' => $sql['partner_label']);
    		} else {
    			$result = array('crop_label' => '', 'product_label' => '', 'village_label' => '', 'partner_label' => '');
    		}
    		return json_encode($result);
    	}
    }
    // ajax for dynamic data
    public function actionDynamicdata()
    {
    	$activity_type = $_REQUEST['type'];
    	$company_id = $_REQUEST['company_id'];
    	$activty_id = $_REQUEST['activity_id'];
    	$final_data_array = array();
    	if($activity_type == 'campaign') {
    	$sql_query = 'SELECT fba.*,fb.step, fb.require, fb.mandatory, fb.label, fb.data_type, fb.validation_type, IF( fb.data_type =  "radio" || fb.data_type =  "checkbox" || fb.data_type =  "selectbox", GROUP_CONCAT( fv.value ORDER BY fv.form_value_id ASC) , fv.value ) AS value, fb.no_of_chars, fb.no_of_images
    				  	FROM form_builder_activities fba
			     		LEFT JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
				     	LEFT JOIN form_value fv ON fb.form_builder_id = fv.form_builder_id
    				  	WHERE fba.activity_id = "'.$activty_id.'"  
    					AND fba.company_id ="'.$company_id.'"
					  	GROUP BY fb.form_builder_id';
    	$query_result = yii::$app->db->createCommand($sql_query)->queryAll();
    	if(!empty($query_result)) {
    		foreach($query_result as $result) {
    			if($result['value'] == null || $result['value'] == '') {
    				$values_array = '';
    			} else {
    				$values_array = explode(',',$result['value']);
    			}
    			$final_data_array['step'.$result['step']][] = array('require' => $result['require'], 'mandatory' => $result['mandatory'],'label' => $result['label'], 'data_type' => $result['data_type'],'validation_type' => $result['validation_type'],'values' => $values_array, 'no_of_images' => $result['no_of_images'],'no_of_chars' => $result['no_of_chars']  );
    		}
    	}
    	//echo '<pre>';print_r($final_data_array);exit;
    	return json_encode($final_data_array);
    	} else if ($activity_type == 'channel') {
    		if (isset($_REQUEST['product_id'])) {
    			/* $sql_query = "select temp.*, GROUP_CONCAT( pi.product_unit) AS product_unit from (SELECT fba.*,fb.step, fb.form_builder_id,fb.require, fb.mandatory, fb.label, fb.data_type, fb.validation_type, IF( fb.data_type =  'radio' || fb.data_type =  'checkbox' || fb.data_type =  'selectbox', GROUP_CONCAT( fv.value
								SEPARATOR  ', ' ) , fv.value ) AS value
		    				  	FROM form_builder_activities fba
					     		LEFT JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
						     	left JOIN form_value fv ON fb.form_builder_id = fv.form_builder_id
		    				  	WHERE fba.activity_id = $activty_id  
		    					AND fba.company_id = $company_id  
							  	GROUP BY fb.form_builder_id) as temp 
		    					LEFT JOIN product_info pi ON pi.form_builder_activity_id = temp.form_builder_activity_id
		    					Where pi.product_id = ".$_REQUEST['product_id']." 
								GROUP BY temp.form_builder_id"; */
    			$sql_query = "SELECT fba.*,fb.step, fb.form_builder_id,fb.require, fb.mandatory, fb.label, fb.data_type, fb.validation_type, IF( fb.data_type =  'radio' || fb.data_type =  'checkbox' || fb.data_type =  'selectbox', GROUP_CONCAT( fv.value
		    					ORDER BY fv.form_value_id ASC) , fv.value ) AS value,fb.no_of_chars, GROUP_CONCAT( fb.product_unit) AS product_unit, fb.no_of_images
		    					FROM form_builder_activities fba
		    					LEFT JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
		    					left JOIN form_value fv ON fb.form_builder_id = fv.form_builder_id
		    					WHERE fba.activity_id = $activty_id 
		    					AND fba.company_id = $company_id 
		    					and fb.product_id = ".$_REQUEST['product_id']." 
		    					GROUP BY fb.form_builder_id";
    		} else {
    			$sql_query = "SELECT fba.*,fb.step, fb.require, fb.mandatory, fb.label, fb.data_type, fb.validation_type, IF( fb.data_type =  'radio' || fb.data_type =  'checkbox' || fb.data_type =  'selectbox', GROUP_CONCAT( fv.value
								ORDER BY fv.form_value_id ASC) , fv.value ) AS value,fb.no_of_chars, fb.no_of_images
		    				  	FROM form_builder_activities fba
					     		LEFT JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
						     	LEFT JOIN form_value fv ON fb.form_builder_id = fv.form_builder_id
		    					WHERE fba.activity_id = $activty_id  
		    					AND fba.company_id = $company_id 
		    					GROUP BY fb.form_builder_id";
    		}
    	$query_result = yii::$app->db->createCommand($sql_query)->queryAll();
    	if(!empty($query_result)) {
    		foreach($query_result as $result) {
    			if($result['value'] == null || $result['value'] == '') {
    				$values_array = '';
    			} else {
    				$values_array = explode(',',$result['value']);
    			}
    			if (!isset($_REQUEST['product_id'])) {
    				$final_data_array['step'.$result['step']][] = array('require' => $result['require'], 'mandatory' => $result['mandatory'],'label' => $result['label'], 'data_type' => $result['data_type'],'validation_type' => $result['validation_type'],'values' => $values_array,'no_of_chars' => $result['no_of_chars'],'no_of_images' => $result['no_of_images'] );
    			} else {
    				$product_unit = explode(',',$result['product_unit']);
    				$prod_unit_array = array();
    				if(!empty($product_unit)) {
    					foreach($product_unit as $prod_unit) {
    						$prod_unit_array[$prod_unit] = $prod_unit;
    					}
    				}
    				$final_data_array['step'.$result['step']][] = array('require' => $result['require'], 'mandatory' => $result['mandatory'],'label' => $result['label'], 'data_type' => $result['data_type'],'validation_type' => $result['validation_type'],'values' => $values_array, 'no_of_chars' => $result['no_of_chars'],'no_of_images' => $result['no_of_images'] );
    			}
    		}
    		
    	}
    	//echo '<pre>';print_r($final_data_array);exit;
    	 
    	return json_encode($final_data_array);
    	}
    }
    //ajax for products names list based on company
    public function actionProductslist()
    {
    	$is_deleted = 0;
    	if (isset($_REQUEST)) {
    		$sql = Yii::$app->db->createCommand("select * from products where comp_id = :company_id and is_deleted = :is_deleted order by product_name")
    		->bindValue(':company_id', $_REQUEST['company_id'])
    		->bindValue(':is_deleted', $is_deleted)
    		->queryAll();
    		$dropdown = '<option value = "" >Select Product </option>';
	  		if(!empty($sql)) {
	  			foreach ($sql as $drop) {
	  				$dropdown .= "<option value = '".$drop['id']."' >".ucfirst($drop['product_name'])."</option>";
	  			}
	  		}
	  		return json_encode($dropdown);
    	}
    }
    public function actionChannelcreate() 
    {
    	$model = new FormBuilder();
    	$formActivity = new FormBuilderActivities();
    	$formValue = new FormValue();
    	$label_names = new LabelNames();
    	$companyList = InputCompanies::companyList();
    	 
    		
    	if ($model->load(Yii::$app->request->post())) {
//     		echo '<pre>';print_r(Yii::$app->request->post());exit;
    		$chform_data = Yii::$app->request->post('FormBuilder');
    		
    		$user_id = Yii::$app->user->identity->id;
    		$expression = new Expression('NOW()');
    		$Company_id = $chform_data['companyid'];
    		$Activity_id = $chform_data['activity'];
    		unset($chform_data['companyid'],$chform_data['activity']);
    		//$product_units = implode(',',$chform_data['product_unit']);
    		/* $step_no2 = $chform_data['step_2_field1_chstepno']; */
    		$step_no2 = $chform_data['step_3_field1_chstepno'];
    		$step_no3 = $chform_data['step_4_field1_chstepno'];
    		//echo '<pre>';print_r($product_units);exit;
    		//delete all records of a product from the company
    		if(isset($chform_data['product_id'])) {
    			$product_id = $chform_data['product_id'];
    		} else {
    			$product_id = 0;
    		}
    		if(isset($chform_data['product_id'])) {
    		$product_id = $chform_data['product_id'];
    		$delete = "delete fb . *, fv.*
			    		FROM form_builder_activities fba
			    		JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
			    		LEFT JOIN form_value fv ON fv.form_builder_id = fb.form_builder_id
			    		WHERE fba.activity_id = $Activity_id
			    		AND fba.company_id = $Company_id
			    		AND fb.product_id = $product_id";
    		Yii::$app->db->createCommand($delete)->execute();
    		}
    		if($chform_data['step_1_chrequire'] == 0) {
    			$delete3 = "DELETE fb. * , fv . *
    			FROM form_builder_activities fba
    			JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
    			LEFT JOIN form_value fv ON fv.form_builder_id = fb.form_builder_id
    			WHERE fba.activity_id = $Activity_id
    			AND fba.company_id = $Company_id";
    			Yii::$app->db->createCommand($delete3)->execute();
    		} 
    		//delete only step 2 and 3 records of a product from the company if already step 2 and 3 exist to any product
    		$delete2 = "DELETE fb. * , fv . *
						FROM form_builder_activities fba
						JOIN form_builder fb ON fb.form_builder_activity_id = fba.form_builder_activity_id
						LEFT JOIN form_value fv ON fv.form_builder_id = fb.form_builder_id
						WHERE fba.activity_id = $Activity_id 
						AND fba.company_id = $Company_id 
						AND fb.step IN ($step_no2, $step_no3 )";
    		Yii::$app->db->createCommand($delete2)->execute();
    		
    		//data unset if it is not require
    		if ($chform_data['step_3_field1_chrequire'] == 0) {
    			unset($chform_data['step_3_field1_chrequire'], $chform_data['step_3_field1_chstepno'],$chform_data['step_3_field1_chno_of_images']);
    		}
//     		if ($chform_data['step_2_field1_chrequire'] == 0) {
//     			unset($chform_data['step_2_field1_chrequire'], $chform_data['step_2_field1_chstepno'],$chform_data['step_2_field1_chno_chars']);
//     		}
    		if ($chform_data['step_4_field1_chrequire'] == 0) {
    			unset($chform_data['step_4_field1_chrequire'], $chform_data['step_4_field1_chstepno'],$chform_data['step_4_field1_chno_chars'],$chform_data['step_4_field1_chno_of_images']);
    		}
    			unset($chform_data['step_1_chrequire']);

//     		echo '<pre>';print_r($chform_data);exit;
    		
    		if(!empty($chform_data)) {
    			foreach ($chform_data as $key => $data) {
    				$steps_array = explode('_',$key);
    				if($steps_array['1'] == 1) {
    					$bulk_steps['step1'][$steps_array['2']][] = $data;
    				}/*  else if($steps_array['1'] == 2) {
    					$bulk_steps['step2'][$steps_array['2']][] = $data;
    				} */ else if($steps_array['1'] == 3) {
    					$bulk_steps['step2'][$steps_array['2']][] = $data;
    				} else if($steps_array['1'] == 4) {
    					$bulk_steps['step3'][$steps_array['2']][] = $data;
    				}
    			}
    		}
//     		echo '<pre>';print_r($bulk_steps);exit;
    		if(!empty($bulk_steps)) {
    		foreach($bulk_steps as $key => $steps) {
    			foreach($steps as $key2 => $array) {
    				/* if($key == 'step2'&& $key2 == 'field1') {
    					$stepno = $array[0];
						$required = $array[1];
						$mandatory = $array[3];
						
    				}
    				if ($key == 'step2'&& $key2 == 'field2') {
    					array_unshift($array,$stepno,$required);
    					array_push($array,$mandatory,'edittext', 8, 'numeric');
    				}
    				if ($key == 'step2'&& $key2 == 'field3') {
    					array_unshift($array,$stepno,$required);
    					array_push($array,$mandatory,'edittext', 8, 'numeric');
    				} */
    				$batchinsert[] = $array;
    			}
    		}
//     		echo '<pre>';print_r($batchinsert);exit;
    	
    		}    
    		$formActivity->activity_id = $Activity_id;
    		$formActivity->company_id = $Company_id;
    		$check_form_buldr_act_id = Yii::$app->db->createCommand("select * from form_builder_activities where activity_id = $Activity_id and company_id = $Company_id")->queryOne();
    		if (!empty($check_form_buldr_act_id)) {
    			$formBulderActvityid = $check_form_buldr_act_id['form_builder_activity_id'];
    		} else {
    			$formActvitySave = $formActivity->save(false);
    			$formBulderActvityid = Yii::$app->db->getLastInsertID();
    		}
    		if(!empty($batchinsert)) {
    			foreach($batchinsert as $key => $formarray)
    			{
    				array_unshift($formarray,$formBulderActvityid);
    				array_push($formarray, $product_id, $user_id, $user_id,$expression,$expression);
    				$batchinsert_array[] = $formarray;
    			}
//     			echo '<pre>';print_r($batchinsert_array);exit;
    			$formBatchInsert = Yii::$app->db->createCommand()->batchInsert('form_builder', ['form_builder_activity_id', 'step', 'require','label', 'mandatory', 'data_type', 'no_of_chars','validation_type', 'no_of_images','product_id','created_by','updated_by','created_date','updated_date'], $batchinsert_array)->execute();
    			Yii::$app->session->setFlash('dynamic-productform-save');
    		}
    		if(!empty($batchinsert)) {
    			foreach ($batchinsert as $k => $v){
    				if($v[4] == "radio"){
    					$valuesIndex[] = array('index' => $k,'stepno' => $v[0]);
    				}else if($v[4] == "checkbox"){
    					$valuesIndex[] = array('index' => $k,'stepno' => $v[0]);
    				} else if ($v[4] == "selectbox"){
    					$valuesIndex[] = array('index' => $k,'stepno' => $v[0]);
    				}
    			}
    		}
    		$totalFormData = Yii::$app->request->post();
    		unset($totalFormData['FormBuilder'],$totalFormData['_csrf']);
    		$formBulderlastid = Yii::$app->db->getLastInsertID();
    		$formbuilderAcId = array();
    		if(!empty($valuesIndex)) {
    			foreach($valuesIndex as $index) {
    				$formbuilderAcId[] = $index['index'] + $formBulderlastid;
    			}
    			$i =0;
    			if(!empty($totalFormData)) {
    				foreach($totalFormData as $values) {
    					array_unshift($values,$formbuilderAcId[$i]);
    					$bulkValuesInsert[] = $values;
    					$i++;
    				}
    			}
    			$bulkValuesInsertNew = array();
    			$index= 0;
    			if(!empty($bulkValuesInsert )) {
    			foreach($bulkValuesInsert as $key => $val){
    				$id = $val[0];
    				unset($val[0]);
    				foreach($val as $key1 => $val1){
    					$bulkValuesInsertNew[$index][] = $id;
    					$bulkValuesInsertNew[$index][] = $val1;
    					$index++;
    				}
    			}
    			}    		
    			if(!empty($bulkValuesInsertNew)) {
    				foreach($bulkValuesInsertNew as $key1 => $formarray1)
    				{
    					array_push($formarray1, $user_id, $user_id,$expression,$expression);
    					$batchinsert_array2[] = $formarray1;
    				}
    			}
    			$formBatchInsert2 = Yii::$app->db->createCommand()->batchInsert('form_value', ['form_builder_id','value','created_by','updated_by','created_date','updated_date'], $batchinsert_array2)->execute();
    			}
    			/* if(!empty($chform_data['product_unit'])) {
    				$products_data = $chform_data['product_unit'];
    				foreach($products_data as $product_unit) {
    					$product_batch_insert[] = array($formBulderActvityid,$product_id,$product_unit);
    				}
    			}
    			$formBatchInsert2 = Yii::$app->db->createCommand()->batchInsert('product_info', ['form_builder_activity_id','product_id','product_unit'], $product_batch_insert)->execute(); */

    	}
    	return $this->redirect(['create']);
    			
    }
}
