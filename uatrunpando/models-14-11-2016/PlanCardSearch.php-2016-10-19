<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlanCards;

/**
 * PlanCardSearch represents the model behind the search form about `app\models\PlanCards`.
 */
class PlanCardSearch extends PlanCards
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'assign_to', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['guid', 'free_text_search', 'card_type', 'planned_date', 'plan_type', 'crop_name', 'product_name', 'channel_partner', 'village_name', 'activity', 'location_name', 'status', 'plan_approval_status', 'start_time', 'created_date', 'updated_date'], 'safe'],
            [['distance_travelled', 'lat_position', 'long_position'], 'number'],
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
    	$controller = Yii::$app->controller->id;
		$action = Yii::$app->controller->action->id;
    	$id=Yii::$app->user->identity->id;
    	if (($action == 'history') && $controller == 'plancard') {
    		$condition = ['=','p.status','submitted'];
    		$orderby = 'p.updated_date desc';
    	} else {
    		$condition = ['!=','p.status','submitted'];
    		$orderby = 'p.planned_date asc';
    	}
    	$query = PlanCards::find()->select("p.*, mv.village_name,c.crop_name, pr.product_name, uu.first_name,IF(p.assign_to = p.created_by, '`self`',`u`.`first_name`) as assignee, uu.first_name,u.first_name as assignee_name,u.employee_number,uuu.first_name as createdby")
		->from('plan_cards p')
		->innerJoin('users u','u.id = p.assign_to')
		->innerJoin('users uuu','uuu.id = p.created_by')
		->innerJoin('users uu','u.reporting_user_id = uu.id')
		->leftJoin('crops c','p.crop_id = c.id')
		->leftJoin('products pr','pr.id = p.product_id')
		->leftJoin('villages_master mv','mv.village_id = p.village_id')
		->andwhere(['uu.id' => $id,'p.is_deleted'=>0])
		->andwhere($condition)
		->orderBy($orderby);
// 		echo '<pre>';print_r($query);exit;
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
            return $dataProvider;
        }
        if(strtolower($this->free_text_search) == 'partner visit') {
        	$this->free_text_search = 'Channel Card';
        } elseif(strtolower($this->free_text_search) == 'partner') {
        	$this->free_text_search = 'channel';
        } elseif(strtolower($this->free_text_search) == 'visit') {
        	$this->free_text_search = 'card';
        } elseif(strtolower($this->free_text_search) == 'channel card') {
        	$this->free_text_search = '&*(***';
        } elseif(strtolower($this->free_text_search) == 'channel') {
        	$this->free_text_search = '&$$$';
        } elseif(strtolower($this->free_text_search) == 'card') {
        	$this->free_text_search = '&$$$dd';
        }
        /* $query->andFilterWhere([
            'id' => $this->id,
            'assign_to' => $this->assign_to,
            'planned_date' => $this->planned_date,
            'distance_travelled' => $this->distance_travelled,
            'lat_position' => $this->lat_position,
            'long_position' => $this->long_position,
            'start_time' => $this->start_time,
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
            ->andFilterWhere(['like', 'location_name', $this->location_name])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'plan_approval_status', $this->plan_approval_status]); */
        $query->innerJoinWith('assignTo');
        $query->andFilterWhere([
        		'assign_to' => $this->assign_to,
        		]);
        if (!empty($params) && !empty($params['PlanCardSearch'])) {
        	if (strchr(trim($params['PlanCardSearch']['free_text_search']), '/')) {
        		if ((substr_count($params['PlanCardSearch']['free_text_search'], '/')) >= 2){
        			$date_array = explode('/', trim($params['PlanCardSearch']['free_text_search']));
        			$date = array_reverse($date_array);
        			$date = implode('-', $date);
        			$query->andFilterWhere(['or',['like', 'planned_date', $date], ['like', 'DATE_FORMAT(p.updated_date, "%Y-%m-%d")', $date]]);
        		}
        	} else {
        		
        		$query->andFilterWhere(['or',
        				['like', 'users.employee_number', trim($this->free_text_search)],
        				['like', 'plan_type', trim($this->free_text_search)],
        				['like', 'activity', trim($this->free_text_search)],
        				['like', 'mv.village_name', trim($this->free_text_search)],
        				['like', 'c.crop_name', trim($this->free_text_search)],
        				['like', 'pr.product_name', trim($this->free_text_search)],
        				['like', 'uuu.first_name', trim($this->free_text_search)]
				        ]);
        		if(strtolower($this->free_text_search) == 'channel card') {
        			$this->free_text_search = 'partner visit';
        		} elseif(strtolower($this->free_text_search) == 'channel') {
        			$this->free_text_search = 'partner';
        		} elseif(strtolower($this->free_text_search) == 'card') {
        			$this->free_text_search = 'visit';
        		} elseif(strtolower($this->free_text_search) == '&*(***') {
        			$this->free_text_search = 'channel card';
        		} elseif(strtolower($this->free_text_search) == '&$$$') {
        			$this->free_text_search = 'channel';
        		}  elseif(strtolower($this->free_text_search) == '&$$$dd') {
        			$this->free_text_search = 'card';
        		}
			}
	    }
	   
        return $dataProvider;
       
    }
}