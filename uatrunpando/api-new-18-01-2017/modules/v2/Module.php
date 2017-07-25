<?php
// Check this namespace:
namespace app\api\modules\v2;
use app\api\modules\v2\models\CardSubmit;

class Module extends \yii\base\Module
{
   public function init()
{
	//$this->versionUpdate();
	CardSubmit::versionUpdate();
    parent::init();
    \Yii::$app->user->enableSession = false;   
}
public function versionUpdate()
{
	echo json_encode(['message' => 'Please update App version', 'status' => true, 'status_code' => '201']);exit;
}
}