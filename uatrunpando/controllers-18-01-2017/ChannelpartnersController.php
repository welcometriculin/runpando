<?php

namespace app\controllers;

use Yii;
use app\models\ChannelPartners;
use app\models\ChannelPartnersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Products;
use app\models\Users;
use app\models\LabelNames;
/**
 * ChannelpartnersController implements the CRUD actions for ChannelPartners model.
 */
class ChannelpartnersController extends KgController
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
		$searchModel = new ChannelPartnersSearch();
		$model = new ChannelPartners();
		$productsList = Products::productList();
		$loginId = Yii::$app->user->identity->id;
		$fieldForce = Users::getRecoursive($loginId,true);
		$channelPartners = Users::getPartners($fieldForce);
		$label_names_display = LabelNames::labelNamesDisplay();
		// $dataProvider = $searchModel->searchDetails(Yii::$app->request->queryParams);
		return $this->render('partners', [
				//	'searchModel' => $searchModel,
				'model'		  => $model,
				'ProductList' => $productsList,
				'PartnersInfo' => $channelPartners,
				'label_names_display' => $label_names_display
		]);

		/* 	return $this->render('index', [
		 'searchModel' => $searchModel,
		 'model'		  =>$model,
		 'dataProvider' => $dataProvider['dataProvider'],
		 'columns' => $dataProvider['columns'],
		]); */
	}

	/**
	 * Displays a single ChannelPartners model.
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
	 * Creates a new ChannelPartners model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new ChannelPartners();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing ChannelPartners model.
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
	 * Deletes an existing ChannelPartners model.
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
	 * Finds the ChannelPartners model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return ChannelPartners the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = ChannelPartners::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	// ajax reqiest for partners

	public function actionAjaxdata()
	{
		$inputCompanyid = Yii::$app->user->identity->input_company_id;
		$managerId = Yii::$app->user->identity->id;
		$activityId = 5;
		$step = 1;
		$produtArray = $productValues = array();
		if(isset($_REQUEST)) {
			$channelPartner = $_REQUEST['channel_partner'];
			$productId =  $_REQUEST['product'];
			$tableArray = $tablesArray = array();
			$produtsQuery = 'SELECT fb.label,fb.product_id,pr.product_name
					FROM form_builder fb
					INNER JOIN form_builder_activities fa ON fb.form_builder_activity_id = fa.form_builder_activity_id
					INNER JOIN products pr on pr.id = fb.product_id
					WHERE fa.company_id ='.$inputCompanyid.'
							AND fa.activity_id = '.$activityId.'
									AND fb.step ='.$step;
			$productLables = Yii::$app->db->createCommand($produtsQuery)->queryAll();
			if(!empty($productLables)) {
				foreach($productLables as $label) {
					$produtArray[$label['product_id']][] = $label['label'];
					$produtArray[$label['product_id']]['name'] = $label['product_name'];

				}
			}
			//echo '<pre>';print_r($produtArray);

			$wherConditon = '';
			if($productId != '') {
				$wherConditon = 'AND cht.product_id ='.$productId;
			}
			$dataQuery = 'SELECT DISTINCT cht.product_id AS product_id, IF(cht.liquidation_status is null or cht.liquidation_status = "", "--",cht.liquidation_status) as liquidation_status,IF(cht.demand_volume is null or cht.demand_volume = "", "--",cht.demand_volume) as demand_volume ,
					IF(cht.season_progress is null or cht.season_progress = "", "--",cht.season_progress) as season_progress,IF(cht.collection_value_four is null or cht.collection_value_four = "", "--",cht.collection_value_four) as collection_value_four,
					p.product_name,IF(cht.collection_value_five is null or cht.collection_value_five = "", "--",cht.collection_value_five) as collection_value_five, cht.updated_date AS updated_date, ms.product_name AS product_name, u.first_name AS fieldforce_name
					FROM plan_cards p
					INNER JOIN users u ON u.id = p.assign_to
					INNER JOIN channel_card_tracking_info cht ON cht.plan_card_id = p.id
					INNER JOIN products ms ON cht.product_id = ms.id
					WHERE (p.card_type="Channel Card") AND (p.status="submitted")
					AND (u.input_company_id = '.$inputCompanyid.') AND (p.channel_partner="'.$channelPartner.'")'.$wherConditon.'  GROUP BY cht.updated_date,product_id ORDER BY cht.updated_date DESC';
			$productsres = Yii::$app->db->createCommand($dataQuery)->queryAll();
			if(!empty($productsres)) {
				foreach($productsres as $produtdata) {
					$productValues[$produtdata['product_id']][] = $produtdata;

				}
			}
			//echo '<pre>';print_r($productValues);exit;
			if(!empty($productValues)) {
				foreach($productValues as $key => $productId) {
					if(in_array($key,array_keys($produtArray))) {
						//echo '<pre>'; print_r($produtArray);exit;
						$table = '<div class="table_section table_cols " ><h3>'.$produtArray[$key]['name'].'</h3><div class ="table-responsive"><table class="table table-striped table-bordered">
								<thead><tr>
								<th>Submit date</th>';
						if(isset($produtArray[$key][0])) {
							if($produtArray[$key][0] != '') {
								$table .= '<th>'.(isset($produtArray[$key][0])?$produtArray[$key][0]:"--").'</th>';
							}
						}
						if(isset($produtArray[$key][1])) {
							if($produtArray[$key][1] != '') {
								$table .= '<th>'.(isset($produtArray[$key][1])?$produtArray[$key][1]:"--").'</th>';
							}
						}
						if(isset($produtArray[$key][2])) {
							if($produtArray[$key][2] != '') {
								$table .= '<th>'.(isset($produtArray[$key][2])?$produtArray[$key][2]:"--").'</th>';
							}
						}
						if(isset($produtArray[$key][3])) {
							if($produtArray[$key][3] != '') {
								$table .= '<th>'.(isset($produtArray[$key][3])?$produtArray[$key][3]:"--").'</th>';
							}
						}
						if(isset($produtArray[$key][4])) {
							if($produtArray[$key][4] != '') {
								$table .= '<th>'.(isset($produtArray[$key][4])?$produtArray[$key][4]:"--").'</th>';
							}
						}
						/* $table .= '<th>'.(isset($produtArray[$key][1])?$produtArray[$key][1]:"--").'</th>
						 <th>'.(isset($produtArray[$key][2])?$produtArray[$key][2]:"--").'</th>';
						 if(isset($produtArray[$key][3]) || $produtArray[$key][3] != '') {
							$table .= 'sss<th>'.(isset($produtArray[$key][3])?$produtArray[$key][3]:"--").'</th>';
							}

							$table .= '<th>'.(isset($produtArray[$key][4])?$produtArray[$key][4]:"--").'</th> */
						$table .= '<th>Field Force</th>
								</tr>
								</thead>
								<tbody>';
						foreach($productId as $val) {
							$table .= '				<tr>
									<td>'.date('d/m/Y',strtotime($val['updated_date'])).'</td>';
							if(isset($produtArray[$key][0])) {
								if($produtArray[$key][0] != '') {
									$table .= '<td>'.$val['liquidation_status'].'</td>';
								}
								}
								if(isset($produtArray[$key][1])) {
									if($produtArray[$key][1] != '') {
										$table .= '<td>'.$val['demand_volume'].'</td>';
									}
								}
								if(isset($produtArray[$key][2])) {
									if($produtArray[$key][2] != '') {
										$table .= '<td>'.$val['season_progress'].'</td>';
									}
								}
								if(isset($produtArray[$key][3])) {
									if($produtArray[$key][3] != '') {
										$table .= '<td>'.$val['collection_value_four'].'</td>';
									}
								}
								if(isset($produtArray[$key][4])) {
									if($produtArray[$key][4] != '') {
										$table .= '<td>'.$val['collection_value_five'].'</td>';
									}
								}

									$table .= '<td>'.$val['fieldforce_name'].'</td></tr>';
								}
								$table .= '</tbody></table></div></div>';
								$tablesArray[] = $table;
							}

						}
							
					}
					//print_r($tablesArray);
					return json_encode($tablesArray);

				}
			}
		}


		/* $dataQuery = ChannelPartners::find()->select("cht.product_id as product_id, cht.liquidation_status as liquidation_status, cht.demand_volume as demand_volume,cht.season_progress as season_progress, cht.product_unit as product_unit, cht.updated_date as updated_date, ms.product_name as product_name, u.first_name as fieldforce_name")
		 ->distinct("product_name")
		 ->from("plan_cards p")
		 ->innerJoin("users u","u.id = p.assign_to")
		 ->innerJoin("channel_partners chp", "u.input_company_id = chp.comp_id AND u.id = chp.user_id")
		 ->innerJoin("channel_card_tracking_info cht, cht.plan_card_id = p.id")
		 ->innerJoin("products ms, cht.product_id = ms.id")
		 ->where(["p.card_type" => "Channel Card",
		 "p.status" => "submitted",
		 "u.input_company_id" => 157,
		 "u.reporting_user_id" => 317,
		 "p.channel_partner" => "Zee media"])
->orderBy("cht.updated_date DESC")->all(); */
//    	INNER JOIN channel_partners chp ON u.input_company_id = chp.comp_id AND u.id = chp.user_id
   
   