<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Crops;

/**
 * CropsSearch represents the model behind the search form about `app\models\Crops`.
 */
class CropsSearch extends Crops
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comp_id', 'user_id', 'created_by', 'role_id', 'updated_by'], 'integer'],
            [['guid', 'crop_name', 'created_date', 'updated_date','free_text_search'], 'safe'],
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
        $query = Crops::find()->where(['comp_id' => $comp_id, 'is_deleted' => 0])->andWhere(['!=', 'role_id', 0])->orderBy(['crop_name' => SORT_ASC]);

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
        if (!empty($params) && !empty($params['CropsSearch'])) {
        	if ($params['CropsSearch']['free_text_search']) {
        		$query->andFilterWhere(['or',
        				['like', 'crop_name', trim($this->free_text_search)]
        		]);
        	}
        }
        /*$query->andFilterWhere([
            'id' => $this->id,
            'comp_id' => $this->comp_id,
            'user_id' => $this->user_id,
            'created_by' => $this->created_by,
            'role_id' => $this->role_id,
            'created_date' => $this->created_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'crop_name', $this->crop_name]);*/

        return $dataProvider;
    }
}
