<?php

namespace app\api\modules\v4\models;

use Yii;

/**
 * This is the model class for table "channel_card_tracking_info".
 *
 * @property string $id
 * @property string $guid
 * @property string $plan_card_id
 * @property string $product_id
 * @property integer $product_unit
 * @property string $liquidation_status
 * @property string $demand_volume
 * @property string $created_by
 * @property string $created_date
 * @property string $updated_by
 * @property string $updated_date
 */
class ChannelCardTrackingInfo extends Kg
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_card_tracking_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'plan_card_id', 'product_id', 'product_unit', 'liquidation_status', 'demand_volume', 'season_progress','collection_value_four','collection_value_five', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'required'],
            [['plan_card_id', 'product_id', 'product_unit', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
        	[['season_progress'], 'number'],
            [['guid', 'liquidation_status', 'demand_volume'], 'string', 'max' => 100]
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
            'product_id' => 'Product ID',
            'product_unit' => 'Product Unit',
            'liquidation_status' => 'Liquidation Status',
            'demand_volume' => 'Demand Volume',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        ];
    }
    /* web service  for channel card products data saving   start*/
    public static function trackinginfo($chct_info,$params)
    {
    	$id = Yii::$app->user->identity->id;
    	foreach ($chct_info as $value) {
    		$model = new ChannelCardTrackingInfo();
    		$model->plan_card_id = $params['data']['plan_card_id'];
    		$model->attributes = $value;
    		$save = $model->save(false);
    	}
    	if (!$save) {
    		return $message = 'Not saved';
    	} else {
    		return $message = 'saved';
    	}
    }
    /* web service  for channel card products data saving   end*/
    
    /* for offline sync start */
    public static function trackinginfo_sync($chct_info, $ch_activity)
    {
    	$id = Yii::$app->user->identity->id;
    	foreach ($chct_info as $value) {
    		$model = new ChannelCardTrackingInfo();
    		$model->plan_card_id = $ch_activity['plan_card_id'];
    		$model->attributes = $value;
    		$save = $model->save(false);
    	}
   		 if (!$save) {
    		$check = 0; 
    	} else {
    		 $check = 1;
    	}
    	return $check;
    }
    /* for offline sync stop */
}


