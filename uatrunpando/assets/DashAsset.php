<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DashAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
   // 'css/site.css',
	'css/bootstrap.min.css',
    'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,600,700,700italic,800,800italic',
	'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
	'css/bootstrap-select.min.css',
	'css/jquery.mCustomScrollbar.min.css',
    'https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css',			
	'css/style.css',
    'css/responsive.css',
	//'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600',
	
    ];
    public $js = [
	//'js/jquery-2.0.3.min.js',
	'js/jquery.mCustomScrollbar.min.js',
	'js/jquery-migrate-1.2.1.min.js',
	//'js/jquery.placeholder.js',
	'js/bootstrap.min.js',
	'js/core.min.js',
    'https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js',		
	'js/bootstrap-select.min.js',
    'js/alert.js',		
    //'js/mod.js',	
    'https://cdnjs.cloudflare.com/ajax/libs/placeholders/4.0.1/placeholders.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
