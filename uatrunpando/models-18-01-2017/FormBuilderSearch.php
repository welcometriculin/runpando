<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FormBuilder;

/**
 * FormBuilderSearch represents the model behind the search form about `app\models\FormBuilder`.
 */
class FormBuilderSearch extends FormBuilder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_builder_id', 'form_builder_activity_id', 'step', 'require', 'mandatory', 'created_by', 'updated_by'], 'integer'],
            [['label', 'data_type', 'validation_type', 'created_date', 'updated_date'], 'safe'],
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
        $query = FormBuilder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'form_builder_id' => $this->form_builder_id,
            'form_builder_activity_id' => $this->form_builder_activity_id,
            'step' => $this->step,
            'require' => $this->require,
            'mandatory' => $this->mandatory,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'data_type', $this->data_type])
            ->andFilterWhere(['like', 'validation_type', $this->validation_type]);

        return $dataProvider;
    }
}
