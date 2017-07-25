<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form about `app\models\Products`.
 */
class ProductsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comp_id', 'user_id', 'created_by', 'role_id', 'updated_by'], 'integer'],
            [['guid', 'product_name', 'created_date', 'updated_date','free_text_search'], 'safe'],
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
        $query = Products::find()->where(['comp_id' => $comp_id, 'is_deleted' => 0])->andWhere(['!=', 'role_id', 0])->orderBy(['product_name' => SORT_ASC]);

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
            ->andFilterWhere(['like', 'product_name', $this->product_name]);*/
        if (!empty($params) && !empty($params['ProductsSearch'])) {
        	if ($params['ProductsSearch']['free_text_search']) {
        		$query->andFilterWhere(['or',
        				['like', 'product_name', trim($this->free_text_search)]
        		]);
        	}
        }
        return $dataProvider;
    }
}
