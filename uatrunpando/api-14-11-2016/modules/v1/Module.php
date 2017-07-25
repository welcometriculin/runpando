<?php
// Check this namespace:
namespace app\api\modules\v1;
use app\api\modules\v1\models\CardSubmit; 
class Module extends \yii\base\Module
{
   public function init()
{
	//CardSubmit::versionUpdate();
    parent::init();
    \Yii::$app->user->enableSession = false;   
}

}
