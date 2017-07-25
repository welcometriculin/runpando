<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InputCompanies;
use yii\data\SqlDataProvider;
/**
 * InputCompaniesSearch represents the model behind the search form about `app\models\InputCompanies`.
 */
class InputCompaniesSearch extends InputCompanies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['guid', 'organization_name', 'person_name', 'contact_email', 'phone_number', 'number_of_licences', 'status', 'created_date', 'updated_date','free_text_search'], 'safe'],
            [['paid_amount'], 'number'],
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
    	//echo '<pre>'; print_r($params);echo '</pre>';exit;
    	$user_role_id = Yii::$app->user->identity->roleid;
    	$email_id = Yii::$app->user->identity->email_address;
    	$kgadmin_role_id = Roles::KGADMIN;
    	$icadmin_role_id = Roles::ICADMIN;
    	$manager_role_id = Roles::MANAGER;
    	$ffofficer_role_id = Roles::FIELDFORCE;
    	$query2 = '';
    	/* if ($user_role_id == $kgadmin_role_id) {
    		$query2 .= "WHERE ic.is_deleted = 0 AND ic.contact_email = u.email_address order by ic.id DESC";
    	} elseif ($user_role_id == $icadmin_role_id) {
    		$query2 .= "WHERE ic.is_deleted = 0 AND ic.contact_email = u.email_address AND u.email_address = '".$email_id."' order by ic.id DESC";
    	}
    	$query = "SELECT distinct(ic.id), ic.guid, ic.person_name, ic.organization_name, ic.phone_number, ic.contact_email, ic.number_of_licences, ic.paid_amount, ic.status, u.designation
    			  FROM input_companies ic 
    			  JOIN users u ON ic.id = u.input_company_id $query2"; */
    	if ($user_role_id == $kgadmin_role_id) {
    		$query2 .= 'ic.is_deleted = 0 and ic.contact_email = u.email_address';
    	} elseif ($user_role_id == $icadmin_role_id) {
    		$query2 .= 'ic.is_deleted = 0 AND ic.contact_email = u.email_address AND u.email_address = "'.$email_id.'"';
    	}
    	$query = InputCompanies::find()->select("ic.id, ic.guid, ic.person_name, ic.organization_name, ic.phone_number, ic.contact_email, ic.number_of_licences, ic.paid_amount, ic.status, u.designation")
		->from('input_companies ic')
		->innerJoin('users u','ic.id = u.input_company_id')
		->where($query2)
		->orderBy(['ic.id' => SORT_DESC]);
    	
    	$dataProvider = new ActiveDataProvider([
            'query' => $query,
    		'pagination' => [
    			'pageSize' => 10,
    		],
        ]);
//        	   $query = InputCompanies::find();
//         $dataProvider = new ActiveDataProvider([
//             'query' => $query,
//         ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//         $query->andFilterWhere([
//             'id' => $this->id,
//             'paid_amount' => $this->paid_amount,
//             'created_date' => $this->created_date,
//             'created_by' => $this->created_by,
//             'updated_date' => $this->updated_date,
//             'updated_by' => $this->updated_by,
//         ]);

//         $query->andFilterWhere(['like', 'organization_name', $this->free_text_search])
//             ->andFilterWhere(['like', 'person_name', $this->free_text_search])
//             ->andFilterWhere(['like', 'contact_email', $this->free_text_search])
//             ->andFilterWhere(['like', 'phone_number', $this->free_text_search])
//             ->andFilterWhere(['like', 'number_of_licences', $this->free_text_search])
//             ->andFilterWhere(['like', 'status', $this->free_text_search]);
            $query->andFilterWhere(['or',
            		['like', 'ic.organization_name', $this->free_text_search],
            		['like', 'u.designation', $this->free_text_search],
            		['like', 'ic.person_name', $this->free_text_search],
            		['like', 'ic.contact_email', $this->free_text_search],
            		['like', 'ic.phone_number', $this->free_text_search],
            		['like', 'ic.number_of_licences', $this->free_text_search],
            		['like', 'ic.status', $this->free_text_search]
            ]);

        return $dataProvider;
    }
}
