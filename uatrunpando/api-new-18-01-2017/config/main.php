<?php
 
$db     = require(__DIR__ . '/../../config/db.php');

$params = require(__DIR__ . '/../../config/params.php');

$config = [
	'timezone' => 'Asia/Kolkata',
    'id' => 'basic',
    'name' => 'TimeTracker',
    // Need to get one level up:
    'basePath' => dirname(__DIR__).'/..',
    'bootstrap' => ['log'],
    'components' => [
    		
	'user' => [
	'identityClass' => 'app\api\modules\v3\models\User',
		'enableAutoLogin' => false,
		], 
        'request' => [
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
    		'guid'=> ['class'=>'app\components\GUID'],
    		/*swift mailer*/
    		'mailer' => [
	    		'class' => 'yii\swiftmailer\Mailer',
	    		// send all mails to a file by default. You have to set
	    		// 'useFileTransport' to false and configure a transport
	    		// for the mailer to send real emails.
	    		'useFileTransport' => false,
	    		'transport' => [
	    		'class' => 'Swift_SmtpTransport',
	    		'host' => 'smtp.gmail.com',
	    		'username' => 'pandohelpdesk@gmail.com',
	    		'password' => 'pando@123',
	    		'port' => '587',
	    		'encryption' => 'tls',
	    		],
    		],
    		/*swift mailer*/
    		'smtpmail'=> [
    				'class'=> 'PHPMailer',
    				'Mailer'=>'smtp',
    				'SMTPAuth'=>true,
    				'Host'=>'smtp.gmail.com',
    				'Port'=> '587',
    				'Username'=>'pandohelpdesk@gmail.com',
    				'Password'=>'pando@123',
    				//'From' => 'contact@greenscoutsofamerica.com',
    				'SMTPSecure' => 'tls',
    		],
	
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                     // Create API log in the standard log dir
                     // But in file 'api.log':
                    'logFile' => '@app/runtime/logs/api.log',
                ],
             'email' => [
                'class' => 'yii\log\EmailTarget',
                'levels' => ['error'],
                'message' => [
                'from' => ['pandohelpdesk@gmail.com'],
                'to' => ['abdul.raheem@raybiztech.com', 'sai.kuncha@raybiztech.com'],
                'subject' => 'webservice-Rasi-QA: Database errors at Kisangates',
                ],
              ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/login','extraPatterns' => ['POST'=>'login','POST forgot'=>'forgot','POST signup'=>'signup'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user','extraPatterns' => ['GET'=>'user','GET image' => 'usr']],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v1/plancard','extraPatterns' => ['GET'=>'cardview','POST'=>'getcard', 'POST create' => 'createcard', 'POST submit' => 'submit','GET check' =>'getdata','GET date' =>'date','POST complete'=>'complete','GET location'=>'location','POST cards'=>'allcards','POST products'=>'products','POST channel'=>'chcard', 'POST travellog' => 'travellog', 'POST travellogstartstop' => 'travellogstartstop' ]],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v1/profile','extraPatterns' => ['GET detail'=>'details','POST edit'=>'edit', 'POST changepassword' => 'changepassword'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v1/syncdb','extraPatterns' => ['POST origin'=>'origin','POST originoffline'=>'originoffline','GET menu'=>'menu','POST offline'=>'offline','POST imagesync' =>'imagesync','GET dynamicform' =>'dynamicform' ],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v1/createplan','extraPatterns' => ['POST crop'=>'addcrop'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v1/performance','extraPatterns' => ['GET travellog'=>'travellog','POST performancelog' => 'performancelog'],'pluralize'=>false],	 
            	
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/login','extraPatterns' => ['POST'=>'login','POST forgot'=>'forgot','POST signup'=>'signup'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/user','extraPatterns' => ['GET'=>'user','GET image' => 'usr']],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/plancard','extraPatterns' => ['GET'=>'cardview','POST'=>'getcard', 'POST create' => 'createcard', 'POST submit' => 'submit','GET check' =>'getdata','GET date' =>'date','POST complete'=>'complete','GET location'=>'location','POST cards'=>'allcards','POST products'=>'products','POST channel'=>'chcard', 'POST travellog' => 'travellog', 'POST travellogstartstop' => 'travellogstartstop' ]],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/profile','extraPatterns' => ['GET detail'=>'details','POST edit'=>'edit', 'POST changepassword' => 'changepassword'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/syncdb','extraPatterns' => ['POST origin'=>'origin','POST originoffline'=>'originoffline','GET menu'=>'menu','POST offline'=>'offline','POST imagesync' =>'imagesync','GET dynamicform' =>'dynamicform' ],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/createplan','extraPatterns' => ['POST crop'=>'addcrop'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v2/performance','extraPatterns' => ['GET travellog'=>'travellog','POST performancelog' => 'performancelog'],'pluralize'=>false],

            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/login','extraPatterns' => ['POST'=>'login','POST forgot'=>'forgot','POST signup'=>'signup'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/user','extraPatterns' => ['GET'=>'user','GET image' => 'usr']],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/plancard','extraPatterns' => ['GET'=>'cardview','POST'=>'getcard', 'POST create' => 'createcard', 'POST submit' => 'submit','GET check' =>'getdata','GET date' =>'date','POST complete'=>'complete','GET location'=>'location','POST cards'=>'allcards','POST products'=>'products','POST channel'=>'chcard', 'POST travellog' => 'travellog', 'POST travellogstartstop' => 'travellogstartstop' ]],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/profile','extraPatterns' => ['GET detail'=>'details','POST edit'=>'edit', 'POST changepassword' => 'changepassword'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/syncdb','extraPatterns' => ['POST origin'=>'origin','POST originoffline'=>'originoffline','GET menu'=>'menu','POST offline'=>'offline','POST imagesync' =>'imagesync','GET dynamicform' =>'dynamicform' ],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/createplan','extraPatterns' => ['POST crop'=>'addcrop'],'pluralize'=>false],
            	['class' => 'yii\rest\UrlRule', 'controller' => 'v3/performance','extraPatterns' => ['GET travellog'=>'travellog','POST performancelog' => 'performancelog'],'pluralize'=>false],
            			 
            ],
        ], 
        'db' => $db,
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\api\modules\v1\Module',
        ],
    	'v2' => [
    		'class' => 'app\api\modules\v2\Module',
    	],
    	'v3' => [
    		'class' => 'app\api\modules\v3\Module',
    	],
    ],
    'params' => $params,
];
 


return $config;