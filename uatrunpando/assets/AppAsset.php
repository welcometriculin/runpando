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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/bootstrap.min.css',	
       // 'css/site.css',
    	'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,600,700,700italic,800,800italic',
    	'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
    	'css/form-elements.css',
    	'css/pando.css',
    	'css/responsive.css',
    ];
    public $js = [
    		'js/bootstrap.min.js',
    		'http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js',
    		'js/classie.js',
    		'js/cbpAnimatedHeader.js',
    		'js/jqBootstrapValidation.js',
    		'js/contact_me.js',
    		'js/pando.js',
    		'https://cdnjs.cloudflare.com/ajax/libs/placeholders/4.0.1/placeholders.min.js',
    		//'js/alert.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
