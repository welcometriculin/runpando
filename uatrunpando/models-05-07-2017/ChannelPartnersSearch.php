<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChannelPartners;
use app\models\PlanCards;
/**
 * ChannelPartnersSearch represents the model behind the search form about `app\models\ChannelPartners`.
 */
class ChannelPartnersSearch extends ChannelPartners
{
	/**
	 * @inheritdoc
	 */

	public function rules()
	{
		return [
		[['id', 'comp_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
		[['guid', 'channel_partner_name', 'status', 'month', 'created_date', 'updated_date'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		//  $query = ChannelPartners::find();
		$user_id = Yii::$app->user->identity->id;
		$company_id = Yii::$app->user->identity->input_company_id;
		$param = array();
		$channel_partner_name = '';
		$status = '';
		$month = '';
		$select_list = "cht.product_id as product_id, cht.liquidation_status as liquidation_status, cht.demand_volume as demand_volume,cht.season_progress as season_progress, cht.product_unit as product_unit, cht.updated_date as updated_date, ms.product_name as product_name, u.first_name as fieldforce_name";
		$distinct = "product_name";
		$join_table = "channel_card_tracking_info cht";
		$join_condition = "cht.plan_card_id = p.id";
		$join_table2 = "products ms";
		$join_condition2 = "cht.product_id = ms.id";
		$where = ["p.card_type" => "Channel Card", "p.status" => "submitted", "u.input_company_id" => $company_id, "u.reporting_user_id" => $user_id];
		$order_by = "cht.updated_date DESC";
		$columns = [
				[
				'label' =>"Your Team",
				'attribute' => 'first_name',
				'value'=> function($data){
					return ucwords($data['fieldforce_name']);
				}
				],
				[
				'label' => 'Product Name',
				'value'=> function($data){
					return ucwords($data['product_name']);
				}
				],
				[
				'label' => 'Supplied',
				'value'=> function($data){
					return ucwords($data['demand_volume']);
				}
				],
				[
				'label' => 'Liquidated',
				'value' => function($data){
					return ucwords($data['liquidation_status']);
				}
				],
				/* [
				'label' =>"Unit",
				'value' => function($data){
					return ucwords($data['product_unit']);
				}
				], */
				[
				'label' =>"Season Progress (%)",
				'value' => function($data){
						return ucwords($data['season_progress']);
				}
				],
				[
				'label' =>"Submitted Date",
				'value' => function($data){
					//return substr($data['updated_date'], 0, 10);
					return \Yii::$app->formatter->asDatetime($data['updated_date'], "php:d/m/Y");;
				}
				]
				];
		if (!empty($params) && !empty($params['ChannelPartnersSearch'])) {
			$param = $params['ChannelPartnersSearch'];
			$channel_partner_name = $param['channel_partner_name'];
			$status = $param['status'];
			$month = $param['month'];
			$current_year = date('Y');
			if ($channel_partner_name == '' && $month == '') {
				$where = ["p.card_type" => "Channel Card",
				"p.status" => "submitted",
				"u.input_company_id" => $company_id,
				"u.reporting_user_id" => $user_id];
			} elseif ($channel_partner_name != '' && $month == '') {
				$where = ["p.card_type" => "Channel Card",
				"p.status" => "submitted",
				"u.input_company_id" => $company_id,
				"u.reporting_user_id" => $user_id,
				"p.channel_partner" => "$channel_partner_name"];
			} elseif ($channel_partner_name != '' && $month != '') {
				$where = ["p.card_type" => "Channel Card",
				"p.status" => "submitted",
				"u.input_company_id" => $company_id,
				"u.reporting_user_id" => $user_id,
				"p.channel_partner" => "$channel_partner_name",
				"MONTH(p.updated_date)" => $month];
			} elseif ($channel_partner_name == '' && $month != '') {
				$where = ["p.card_type" => "Channel Card",
				"p.status" => "submitted",
				"u.input_company_id" => $company_id,
				"u.reporting_user_id" => $user_id,
				"MONTH(p.updated_date)" => $month];
			}
			if ($status == 'product') {
				$select_list = "cht.product_id as product_id, cht.liquidation_status as liquidation_status, cht.demand_volume as demand_volume,cht.season_progress as season_progress, cht.product_unit as product_unit, cht.updated_date as updated_date, ms.product_name as product_name, u.first_name as fieldforce_name";
				$distinct = "product_name";
				$join_table = "channel_card_tracking_info cht";
				$join_condition = "cht.plan_card_id = p.id";
				$join_table2 = "products ms";
				$join_condition2 = "cht.product_id = ms.id";
				$order_by = "cht.updated_date DESC";
				$columns = [
				[
				'label' =>"Your Team",
				'attribute' => 'first_name',
				'value'=> function($data){
					return ucwords($data['fieldforce_name']);
				}
				],
				[
				'label' => 'Product Name',
				'value'=> function($data){
					return ucwords($data['product_name']);
				}
				],
				[
				'label' => 'Supplied',
				'value'=> function($data){
					return ucwords($data['demand_volume']);
				}
				],
				[
				'label' => 'Liquidated',
				'value' => function($data){
					return ucwords($data['liquidation_status']);
				}
				],
				[
				'label' =>"Season Progress",
						'value' => function($data){
						return ucwords($data['season_progress']);
				}
				],
				[
				'label' =>"Unit",
				'value' => function($data){
					return ucwords($data['product_unit']);
				}
				],
				[
				'label' =>"Submitted Date",
				'value' => function($data){
					return substr($data['updated_date'], 0, 10);
				}
				]
				];
			} else {
				$select_list = "chcac.id as id, chcac.updated_date as dates_visited, chcac.target_value as target_value, chcac.actual_value as actual_value, u.first_name as fieldforce_name";
				$distinct = "id";
				$join_table = "channel_card_activities chcac";
				$join_condition = "chcac.plan_card_id = p.id";
				$join_table2 = "channel_card_activities chcact";
				$join_condition2 = "chcact.userid = p.assign_to";
				$order_by = "chcac.updated_date DESC";
				$columns = [
				[
				'label' =>"Your Team",
				'attribute' => 'first_name',
				'value'=> function($data){
					return ucwords($data['fieldforce_name']);
				}
				],
				[
				'label' => 'Dates Visited',
				'value'=> function($data){
					return substr($data['dates_visited'], 0, 10);
				}
				],
				[
				'label' => 'Target (Rs.)',
				'value'=> function($data){
					return ucwords($data['target_value']);
				}
				],
				[
				'label' => 'Collection (Rs.)',
				'value' => function($data){
					return ucwords($data['actual_value']);
				}
				],
				];
			}
		}
		 
		$query = ChannelPartners::find()->select($select_list)
		->distinct($distinct)
		->from("plan_cards p")
		->innerJoin("users u","u.id = p.assign_to")
		->innerJoin("channel_partners chp", "u.input_company_id = chp.comp_id AND u.id = chp.user_id")
		->innerJoin($join_table, $join_condition)
		->innerJoin($join_table2, $join_condition2)
		->where($where)
		->orderBy($order_by)->all();
// 		echo '<pre>';print_r(var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql));exit;
		$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
				'pageSize' => 10,
				],
				]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return ['dataProvider' => $dataProvider, 'columns' => $columns ];
		}

		$query->andFilterWhere([
				'id' => $this->id,
				'comp_id' => $this->comp_id,
				'user_id' => $this->user_id,
				'created_by' => $this->created_by,
				'created_date' => $this->created_date,
				'updated_by' => $this->updated_by,
				'updated_date' => $this->updated_date,
				]);

		$query->andFilterWhere(['like', 'guid', $this->guid])
		->andFilterWhere(['like', 'channel_partner_name', $this->channel_partner_name]);

		return ['dataProvider' => $dataProvider, 'columns' => $columns ];
	}
	public function searchDetails($params)
	 {
	 	
		return;
	}
}
