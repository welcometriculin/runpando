<?php
// Check this namespace:
namespace app\api\modules\v4;
 
class Module extends \yii\base\Module
{
   public function init()
{
	//$this->versionUpdate();
    parent::init();
    \Yii::$app->user->enableSession = false;   
}
public function versionUpdate()
{
	echo json_encode(['message' => 'Please update App version', 'status' => true, 'status_code' => '201']);exit;
}
}