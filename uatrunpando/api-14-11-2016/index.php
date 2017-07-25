<?php
ini_set("memory_limit","512M");
ini_set("max_execution_time",60);
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

// Use a distinct configuration for the API
$config = require(__DIR__ . '/config/main.php');
 // echo 'sflk';exit;
(new yii\web\Application($config))->run();

?>