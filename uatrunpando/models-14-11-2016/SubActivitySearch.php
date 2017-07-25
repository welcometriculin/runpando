<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubActivity;

/**
 * SubActivitySearch represents the model behind the search form about `app\models\SubActivity`.
 */
class SubActivitySearch extends SubActivity
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sub_activity_id', 'activity_id', 'company_id', 'created_by', 'updated_by'], 'integer'],
            [['sub_activity_name', 'created_date', 'updated_date','free_text_search'], 'safe'],
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
    	$comp_id = Yii::$app->user->identity->input_company_id;
        $query = SubActivity::find()->select('act.activity_id, act.activity_name, subact.guid, subact.activity_id, subact.sub_activity_name')
        ->from('sub_activity subact')
        ->innerJoin('activity act', 'act.activity_id = subact.activity_id')
        ->where(['subact.company_id' => $comp_id, 'subact.is_deleted' => 0]);

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

       /* $query->andFilterWhere([
            'sub_activity_id' => $this->sub_activity_id,
            'activity_id' => $this->activity_id,
            'company_id' => $this->company_id,
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'sub_activity_name', $this->sub_activity_name]);*/
        if (!empty($params) && !empty($params['SubActivitySearch'])) {
        	if ($params['SubActivitySearch']['free_text_search']) {
        		$query->andFilterWhere(['or',
        				['like', 'act.activity_name', trim($this->free_text_search)],
        				['like', 'subact.sub_activity_name', trim($this->free_text_search)]
        		]);
        	}
        }
        return $dataProvider;
    }
}
