<?php

namespace app\api\modules\v3\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email_address
 * @property string $password
 * @property integer $roleid
 * @property integer $input_company_id
 * @property integer $reporting_to
 * @property string $status
 * @property string $access_token
 * @property string $auth_key
 * @property string $created_date
 * @property integer $created_by
 * @property string $updated_date
 * @property integer $updated_by
 *
 * @property CampaignCardActivities[] $campaignCardActivities
 * @property ChannelCardActivities[] $channelCardActivities
 * @property PlanCards[] $planCards
 * @property Role $role
 */
class Kg extends ActiveRecord
{
	public function behaviors()
	{
		return [
				//automatic guid creation
				[
				'class' => AttributeBehavior::className(),
				'attributes' => [
				ActiveRecord::EVENT_BEFORE_INSERT => 'guid',
				],
				'value' => function ($event) {
					if (Yii::$app->user->isGuest) {
						return  Yii::$app->guid->generate();
					} else {
						return  Yii::$app->guid->generate();
					}
				},
				],
				//automatic create and update by
// 				[
// 				'class' => BlameableBehavior::className(),
// 				'createdByAttribute' => 'created_by',
// 				'updatedByAttribute' => 'updated_by',
// 				],
				[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'created_by',
				'updatedByAttribute' => 'updated_by',
                'attributes' => [
            		ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
            		ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
            		],
            		'value' => function ($event) {
            		if (Yii::$app->user->isGuest) {
            			return  '0';
            		} else {
            			return  Yii::$app->user->identity->id;
            		}
				   },
				],
		        //automatic create and update dates
		        [
		        'class' => TimestampBehavior::className(),
		        'createdAtAttribute' => 'created_date',
		        'updatedAtAttribute' => 'updated_date',
		            'value' => new Expression('NOW()'),
		        ],
		];
	}

}
