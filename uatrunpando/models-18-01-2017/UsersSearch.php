<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;
use app\models\Roles;

/**
 * UsersSearch represents the model behind the search form about `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employee_number', 'roleid', 'input_company_id', 'reporting_user_id', 'created_by', 'updated_by'], 'integer'],
            [['guid', 'free_text_search', 'first_name', 'last_name', 'designation', 'phone_number', 'email_address', 'password', 'photo', 'photo_path', 'state', 'district', 'head_quarters', 'area_of_operatoin', 'status', 'access_token', 'auth_key', 'created_date', 'updated_date'], 'safe'],
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
    	$user_role_id = Yii::$app->user->identity->roleid;
    	$ic_id = Yii::$app->user->identity->input_company_id;
    	$email_id = Yii::$app->user->identity->email_address;
    	$reporting_user_id = Yii::$app->user->identity->id;
    	
    	$kgadmin_role_id = Roles::KGADMIN;
    	$icadmin_role_id = Roles::ICADMIN;
    	$manager_role_id = Roles::MANAGER;
    	$ffofficer_role_id = Roles::FIELDFORCE;
    	if ($user_role_id == $kgadmin_role_id) {
        	$query = Users::find()->where(['input_company_id' => $ic_id, 'is_deleted' => 0])->orderBy('id DESC');
       	} else if ($user_role_id == $icadmin_role_id) {
			$query = Users::find()->where(['input_company_id' => $ic_id, 'is_deleted' => 0])->andWhere(['!=','roleid',$user_role_id])->orderBy('id DESC');
       	} else if($user_role_id == $manager_role_id) 	{
       		$query = Users::find()->where(['input_company_id' => $ic_id, 'is_deleted' => 0, 'reporting_user_id' => $reporting_user_id])->orderBy('id DESC');
       	}
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
            'id' => $this->id,
            'employee_number' => $this->employee_number,
            'roleid' => $this->roleid,
            'input_company_id' => $this->input_company_id,
            'reporting_user_id' => $this->reporting_user_id,
            'created_date' => $this->created_date,
            'created_by' => $this->created_by,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'guid', $this->guid])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'email_address', $this->email_address])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'photo_path', $this->photo_path])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'head_quarters', $this->head_quarters])
            ->andFilterWhere(['like', 'area_of_operatoin', $this->area_of_operatoin])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]); */
        $query->innerJoinWith('role');
        if (!empty($params) && !empty($params['UsersSearch'])) {
        	if (!is_numeric($params['UsersSearch']['free_text_search'])) {
        		$query->andFilterWhere(['or',
        				['like', 'first_name', trim($this->free_text_search)],
        				['like', 'employee_number', trim($this->free_text_search)],
        				['like', 'email_address', trim($this->free_text_search)],
        				['like', 'roles.role_name', trim($this->free_text_search)],
        				['like', 'area_of_operatoin', trim($this->free_text_search)],
        				['like', 'status', trim($this->free_text_search)]
        				]);
        	} else {
        		$query->having(['or',
        				['like', 'employee_number', trim($this->free_text_search)],
        				['like', 'phone_number', trim($this->free_text_search)]
        				]);
        	}
        }
        
        return $dataProvider;
    }
}
