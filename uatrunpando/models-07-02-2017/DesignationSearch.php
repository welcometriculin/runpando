<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Designations;

/**
 * DesignationSearch represents the model behind the search form about `app\models\Designations`.
 */
class DesignationSearch extends Designations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation_id', 'company_id', 'created_by', 'updated_by'], 'integer'],
            [['designation_name', 'created_date', 'updated_date'], 'safe'],
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
    	$is_delete = 0;
        $query = Designations::find()->where(['company_id' => Yii::$app->user->identity->input_company_id,'is_deleted' => $is_delete])->orderBy('designation_name ASC');

        // add conditions that should always apply here

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

        // grid filtering conditions
        $query->andFilterWhere([
            'designation_id' => $this->designation_id,
            'company_id' => $this->company_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'designation_name', $this->designation_name]);

        return $dataProvider;
    }
}
