<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Villages;

/**
 * VillagesSearch represents the model behind the search form about `app\models\Villages`.
 */
class VillagesSearch extends Villages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comp_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['guid', 'village_name', 'created_date', 'updated_date','free_text_search'], 'safe'],
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
    	$company_id = Yii::$app->user->identity->input_company_id;
        $query = (new \yii\db\Query())
        				->select('v.village_id,vm.village_name,v.guid,u.first_name')
        				->from('villages v')
        				->innerJoin('villages_master vm','vm.village_id = v.village_id')
        				->innerJoin('users u','u.id = v.user_id')
        				->where(['v.comp_id' => $company_id,'v.is_deleted' => 0])
       					 ->orderBy('vm.village_name ASC');

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

       if (!empty($params) && !empty($params['VillagesSearch'])) {
        	if ($params['VillagesSearch']['free_text_search']) {
        		$query->andFilterWhere(['or',
        				['like', 'u.first_name', trim($this->free_text_search)],
        				['like', 'vm.village_name', trim($this->free_text_search)]
        				]);
        	}
      }
        return $dataProvider;
    }
}
