<?php

namespace app\api\modules\v3\models;
use Yii;

/**
 * This is the model class for table "campaign_card_activities".
 *
 * @property integer $id
 * @property integer $plan_card_id
 * @property string $distance_travelled
 * @property string $contacted_person_name
 * @property string $contacted_person_phone
 * @property string $feedback
 * @property string $purpose
 * @property string $picture1
 * @property string $picture2
 * @property string $picture3
 * @property integer $userid
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 *
 * @property PlanCards $planCard
 * @property Users $user
 */
class CampaignCardActivities extends Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_card_activities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid','plan_card_id','contacted_person_name', 'contacted_person_phone','lat_position','long_position','location_name','no_of_farmers','no_of_female_farmers','no_of_retailers','no_of_villages', 'feedback', 'purpose', 'sub_activity_id', 'picture1', 'picture2', 'picture3', 'userid', 'created_date', 'created_by', 'updated_date', 'updated_by'], 'required'],
            [['plan_card_id', 'userid', 'created_by', 'updated_by','no_of_farmers','no_of_female_farmers','no_of_retailers','no_of_villages','no_of_dealers', 'sub_activity_id'], 'integer'],
            [['feedback'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['contacted_person_name'], 'string', 'max' => 100],
            [['contacted_person_phone'], 'string', 'max' => 15],
            [['purpose'], 'string', 'max' => 250],
            [['picture1', 'picture2', 'picture3'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan_card_id' => 'Plan Card ID',
            'distance_travelled' => 'Distance Travelled',
            'contacted_person_name' => 'Contacted Person Name',
            'contacted_person_phone' => 'Contacted Person Phone',
            'feedback' => 'Feedback',
            'purpose' => 'Purpose',
            'picture1' => 'Picture1',
            'picture2' => 'Picture2',
            'picture3' => 'Picture3',
            'userid' => 'Userid',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
        ];
    }
    public function scenarios()
    {
    	$scenarios = parent::scenarios();
    	//$scenarios['signin'] = ['username', 'password'];
    	//$scenarios['create'] = ['planned_date', 'assign_to', 'crop_name', 'activity','channel_partner','village_name'];
    	$scenarios['insertservice '] = ['username', 'email', 'password', 'role_id'];
    	return $scenarios;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanCard()
    {
        return $this->hasOne(PlanCards::className(), ['id' => 'plan_card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
    }
    /* everday completed cards location list service  start */
 public static function locationList()
    {
    	
  
    	$user_id=Yii::$app->user->identity->id;
    	$sql="select  p.id as plan_card_id,p.village_name,p.planned_date,p.distance_travelled,
    	p.updated_date, p.activity,p.card_type,p.status,p.lat_position,p.long_position,p.location_name
    	from plan_cards p
    	where p.status='submitted' and p.assign_to= '".$user_id."' and
    	DATE_FORMAT(p.updated_date, '%Y-%m-%d') = CURDATE()
    			ORDER BY p.updated_date DESC";
    /*	$sql = "SELECT id,plan_card_id,lat_position,long_position,location_name from campaign_card_activities WHERE updated_date > DATE_SUB( NOW( ) , INTERVAL 1 
DAY ) AND userid ='".$user_id."'";*/
    	return $q = Yii::$app->db->createCommand($sql)->queryAll();
    
    }
    /* everday completed cards location list service  end */
}
