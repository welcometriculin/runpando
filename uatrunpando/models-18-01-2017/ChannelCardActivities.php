<?php

namespace app\models;

use Yii;
use yii\db\Expression;
/**
 * This is the model class for table "channel_card_activities".
 *
 * @property string $id
 * @property string $guid
 * @property string $plan_card_id
 * @property string $target_value
 * @property string $actual_value
 * @property string $feedback
 * @property string $userid
 * @property string $created_date
 * @property string $created_by
 * @property string $updated_date
 * @property string $updated_by
 *
 * @property Users $user
 * @property PlanCards $planCard
 * @property PlanCards $planCard0
 */
class ChannelCardActivities extends Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_card_activities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'plan_card_id', 'target_value', 'actual_value', 'feedback', 'userid', 'created_date', 'created_by', 'updated_date', 'updated_by'], 'required'],
            [['plan_card_id', 'userid', 'created_by', 'updated_by'], 'integer'],
            [['target_value', 'actual_value'], 'number'],
            [['feedback'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['guid'], 'string', 'max' => 50],
            [['guid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'plan_card_id' => 'Plan Card ID',
            'target_value' => 'Target Value',
            'actual_value' => 'Actual Value',
            'feedback' => 'Feedback',
            'userid' => 'Userid',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'userid']);
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
    public function getPlanCard0()
    {
        return $this->hasOne(PlanCards::className(), ['id' => 'plan_card_id']);
    }
    //web services start
    public static function channelcardinfo($params)
    {
    	$model = new ChannelCardActivities();
    	$id = Yii::$app->user->identity->id;
    	//$model->target_value = $params['data']['target_value'];
    	//$model->actual_value = $params['data']['actual_value'];
    	$model->feedback = $params['data']['feedback'];
    	$model->userid = $id;
    	$model->plan_card_id = $params['data']['plan_card_id'];
    	$last_insert_id = ChannelCardActivities::find()->select('id')->orderBy('id DESC')->one();
    	$model->mobile_timestamp = $last_insert_id['id'] + 1;
    	$model->mode = 'online';
    	$save = $model->save(false);
    	$lastCardId = Yii::$app->db->getLastInsertID();
    	$chImages = $params['data']['images'];
    	$de_images = PlanCards::decodeImage($chImages,$id);
    	if(!empty($de_images)) {
    		foreach($de_images as $Imgage) {
    			$ImageName = end((explode("/",$Imgage)));
    			$imagePath = str_replace(end((explode("/",$Imgage))),'',str_replace('../web/','',$Imgage));
    			$imagesArray[] = array($ImageName, $imagePath, $lastCardId, $params['data']['plan_card_id'], $id, $id, new Expression('NOW()'), new Expression('NOW()'));
    		}
    		$imageBatchInsert = Yii::$app->db->createCommand()->batchInsert('channel_card_images', ['image_name', 'image_path','channel_card_activity_id','plan_card_id','updated_by','created_by','created_date','updated_date'], $imagesArray)->execute();
    		if (!$save && !$imageBatchInsert) {
    			return $message = 'Not saved';
    		} else {
    			return $message = 'saved';
    		}
    	}
    	 /* 
    if (!$save) {
    		return $message = 'Not saved';
    	} else {
    		return $message = 'saved';
    	} */
    }
    //for offline sync start
    public static function channelcardinfo_sync($ch_activity)
    {
    	$model = new ChannelCardActivities();
    	$id = Yii::$app->user->identity->id;
    	//$model->target_value = $ch_activity['target_value'];
    	//$model->actual_value = $ch_activity['actual_value'];
    	$model->feedback = $ch_activity['feedback'];
    	$model->userid = $id;
    	$model->plan_card_id = $ch_activity['plan_card_id'];
    	$save = $model->save(false);
    
    	if (!$save) {
    		 $check = 0;
    	} else {
    		 $check = 1;
    	}
    	return $check;
    }
    //for offline sync end
    //web services end
}
