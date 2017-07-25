<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ChannelPartners;

/**
 * RetailerSearch represents the model behind the search form about `app\models\ChannelPartners`.
 */
class RetailerSearch extends ChannelPartners
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comp_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['guid', 'channel_partner_name', 'created_date', 'updated_date','free_text_search'], 'safe'],
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
        					->select('ch.channel_partner_name,us.first_name,ch.guid')
        					->from('channel_partners ch')
        					->innerJoin('users us','us.id = ch.user_id')
        					->where(['ch.comp_id' => $company_id,'ch.is_deleted' => 0])
        					->orderBy('ch.channel_partner_name ASC');

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
     if (!empty($params) && !empty($params['RetailerSearch'])) {
        	if ($params['RetailerSearch']['free_text_search']) {
        		$query->andFilterWhere(['or',
        				['like', 'ch.channel_partner_name', trim($this->free_text_search)],
        				['like', 'us.first_name', trim($this->free_text_search)]
        		]);
        	}
        }

        return $dataProvider;
    }
}
