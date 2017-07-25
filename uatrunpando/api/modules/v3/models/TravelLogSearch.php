<?php

namespace app\api\modules\v3\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TravelLog;
use yii\data\SqlDataProvider;
use app\models\UserTravellog;
/**
 * TravelLogSearch represents the model behind the search form about `app\models\TravelLog`.
 */
class TravelLogSearch extends TravelLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'assign_to', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['guid', 'free_text_search', 'card_type', 'planned_date', 'plan_type', 'crop_name', 'product_name', 'channel_partner', 'village_name', 'activity', 'status', 'plan_approval_status', 'created_date', 'updated_date'], 'safe'],
            [['distance_travelled'], 'number'],
        	['free_text_search','trim']
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
    	$user_id = Yii::$app->user->identity->id;
    	$query = TravelLog::find()->select('p.id, p.guid, p.updated_date, p.assign_to, SUM(p.distance_travelled) as distance_travelled, GROUP_CONCAT(p.location_name) AS location_name, COUNT(p.id) AS plan_card_count, u.first_name')
						    	->from('plan_cards p')
						    	->innerJoin('users u', 'u.id = p.assign_to')
						    	->where(['p.status' => 'submitted'])
						    	->andWhere(['u.reporting_user_id' => $user_id])
						    	->groupBy(['DATE(p.updated_date)', 'p.assign_to']);
    	$query2 = TravelLog::find()->select("p.id, p.guid, ut.date_time AS updated_date, ut.user_id AS assign_to, SUM(ut.distance_travelled) as distance_travelled, ut.location_name AS location_name, '`0`' as  plan_card_count, u.first_name")
						    	->from('user_travellog ut')
						    	->innerJoin('plan_cards p', 'p.assign_to = ut.user_id')
						    	->innerJoin('users u', 'u.id = ut.user_id')
						    	->where(['u.reporting_user_id' => $user_id])
						    	->groupBy(['DATE(ut.date_time), ut.user_id']);
    	$union = (new \yii\db\Query())
    	                ->select('guid, updated_date, assign_to, SUM(distance_travelled) as distance_travelled ,location_name,plan_card_count,first_name')
				    	->from(['dummy_name' => $query->union($query2)])
				    	->groupBy(['date(updated_date)', 'assign_to'])
				    	->orderBy(['updated_date' => SORT_DESC]);
		
		$dataProvider = new ActiveDataProvider([
            'query' => $union,
        	'pagination' => [
        		'pageSize' => 10,
        	],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /* $query->andFilterWhere([
            'id' => $this->id,
            'assign_to' => $this->assign_to,
            'planned_date' => $this->planned_date,
            'distance_travelled' => $this->distance_travelled,
            'created_date' => $this->created_date,
            'created_by' => $this->created_by,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'card_type', $this->card_type])
            ->andFilterWhere(['like', 'plan_type', $this->plan_type])
            ->andFilterWhere(['like', 'crop_name', $this->crop_name])
            ->andFilterWhere(['like', 'product_name', $this->product_name])
            ->andFilterWhere(['like', 'channel_partner', $this->channel_partner])
            ->andFilterWhere(['like', 'village_name', $this->village_name])
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'plan_approval_status', $this->plan_approval_status]); */
        $query->innerJoinWith('assignTo');
       	$query->andFilterWhere([
        		'assign_to' => $this->assign_to,
        		]);
        $query2->andFilterWhere([
        		'assign_to' => $this->assign_to,
        		]);
        if (!empty($params) && !empty($params['TravelLogSearch']) && (!empty($params['TravelLogSearch']['free_text_search']) || $params['TravelLogSearch']['free_text_search'] == 0)) {
        	if (is_numeric($params['TravelLogSearch']['free_text_search']) || $params['TravelLogSearch']['free_text_search'] === '0'){
	        	$params['TravelLogSearch']['free_text_search'] = $params['TravelLogSearch']['free_text_search'] + 0; //for typecasting problem changing float
	        	if (!is_float($params['TravelLogSearch']['free_text_search'])) {
		        	$query->having(['or',
		        			['=', 'plan_card_count', $this->free_text_search],
		        			['like', 'distance_travelled', $this->free_text_search],
		        			['like', 'DAY(p.updated_date)', $this->free_text_search]
		        			]);
		        	$query2->having(['or',
		        			['=', 'plan_card_count', $this->free_text_search],
		        			['like', 'distance_travelled', $this->free_text_search],
		        			['like', 'DAY(ut.date_time)', $this->free_text_search]
		        			]);
		        } elseif (is_float($params['TravelLogSearch']['free_text_search'])) {
		        	$query->having(['or',
		        			['like', 'distance_travelled', $this->free_text_search]
							]);
		        	$query2->having(['or',
		        			['like', 'distance_travelled', $this->free_text_search]
		        			]);
		        }
        	} else {
        		//for months search
        		$months = array();
				for ($i = 0; $i < 12; $i++) {
					$month_numbers = date('m', strtotime("-$i month"));
					$month_names = date('M', strtotime("-$i month"));
					$months[$month_numbers] = $month_names;
				}
				ksort($months);
				//for months search end
				//for days search
				$days = array();
				$type = CAL_GREGORIAN;
				$month = date('m');
				$year = date('Y');
				$day_count = cal_days_in_month($type, $month, $year); // or date('t') Get the amount of days
				for ($i = 1; $i <= $day_count; $i++) {
					$date = $year.'/'.$month.'/'.$i; //format date
        			$days[$i] = date('D',strtotime($date));
        		}
				//for days search end
				if (in_array(ucfirst($params['TravelLogSearch']['free_text_search']), $months)) {
					$month_number = array_search(ucfirst($params['TravelLogSearch']['free_text_search']), $months);
					$query->andFilterWhere(['or',
							['=', 'MONTH(p.updated_date)', $month_number]
							]);
					$query2->andFilterWhere(['or',
							['=', 'MONTH(ut.date_time)', $month_number]
							]);
				} elseif (in_array(ucfirst($params['TravelLogSearch']['free_text_search']), $days)) {
					$day_value = ucfirst($params['TravelLogSearch']['free_text_search']);
					foreach ($days as $day_keys => $day_values) {
						if ($day_values == $day_value) {
							$day_numbers[] = $day_keys;
						}
					}
					$query->andFilterWhere(['or',
							[ 'IN', 'DAY(p.updated_date)', $day_numbers]
							]);
					$query2->andFilterWhere(['or',
							[ 'IN', 'DAY(ut.date_time)', $day_numbers]
							]);
				} elseif(preg_match('/\\d/', $params['TravelLogSearch']['free_text_search']) > 0) {
					$date_value = date('Y-m-d', strtotime($params['TravelLogSearch']['free_text_search']));
					$query->andFilterWhere(['or',
		        			['like', 'DATE(p.updated_date)', $date_value]
		        			]);
					$query2->andFilterWhere(['or',
							['like', 'DATE(ut.date_time)', $date_value]
							]);
				} else {
					$query->andFilterWhere(['or',
							['like', 'u.first_name', $this->free_text_search]
							]);
					$query2->andFilterWhere(['or',
							['like', 'u.first_name', $this->free_text_search]
							]);
				}
	        }
        }
       
//     	$query = TravelLog::findBySql("select p.id from plan_cards p 
//     			JOIN users u ON u.id = p.assign_to 
//     			where p.status = 'submitted' 
//     			AND u.reporting_user_id = '".Yii::$app->user->identity->id."'
//     			group by DATE_FORMAT(p.updated_date, '%Y-%m-%d')");
//     	$totalCount = $query->count();
//     	$dataProvider = new SqlDataProvider([
//     			'sql' => "select CONCAT(u.first_name , u.last_name) as first_last_name, p.id, p.updated_date, p.assign_to, SUM(p.distance_travelled) as distance_travelled, GROUP_CONCAT(p.village_name) as village_name from plan_cards p
// 						  JOIN users u ON u.id = p.assign_to
//  						  where p.status = 'submitted' 
//     					  AND u.reporting_user_id = '".Yii::$app->user->identity->id."'
//     					  group by DATE_FORMAT(p.updated_date, '%Y-%m-%d') 
//     					  order by DATE_FORMAT(p.updated_date, '%Y-%m-%d') DESC",
//     			'totalCount' => $totalCount,
//     			'pagination' => [
//     				'pageSize' => 10,
//     			],
//     	]);
        return $dataProvider;
    }
    
    public function details($params)
    {
    	$id = $params['id'];
    	$ff = TravelLog::travellogFfId($id);
    	$date = $params['date']; 
    	$query = TravelLog::find()->select('id, location_name, activity, distance_travelled, start_time, updated_date as end_time,order_number')
								    	 ->from('plan_cards')
								    	 ->where(['status' => 'submitted'])
								    	 ->andWhere(['assign_to' => $ff['assign_to']])
								    	 ->andWhere(['DATE_FORMAT(updated_date, "%Y-%m-%d")' => $date]);
    	$query2 = UserTravellog::find()->select('id, location_name, type as activity, distance_travelled, start_time, date_time as end_time,order_number')
								    	->where(['user_id' => $ff['assign_to']])
								    	->andWhere(["DATE_FORMAT(date_time, '%Y-%m-%d')" => "$date"]);
    	$unionQuery = (new \yii\db\Query())
				    	->from(['dummy_name' => $query->union($query2)])
				    	->orderBy(['order_number' => SORT_DESC, 'end_time' => SORT_DESC]);
    	$distance_travelled = (new \yii\db\Query())
    					->select('sum(distance_travelled) as distance_travelled ')
				    	->from(['dummy_name' => $query->union($query2)])
    					->one();
    	$dataProvider = new ActiveDataProvider([
    			'query' => $unionQuery,
    			'pagination' => [
    			'pageSize' => 10,
    			],
    			]);
     	return ['dataProvider' => $dataProvider, 'distance_travelled' => $distance_travelled['distance_travelled']];
        }
}
