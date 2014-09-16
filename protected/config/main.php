<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Snailz',
        'theme'=>'mobile',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.libraries.*',
                'application.config.Constants',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'flikkable',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
               'errorHandler'=>array(
                    'errorAction'=>'site/error',
                ),
                'email'=>array(
                    'class'=>'application.extensions.email.Email',
                    'delivery'=>'php', //Will use the php mailing function.  
                    //May also be set to 'debug' to instead dump the contents of the email into the view
                ),
             'clientScript'=>array(
                'packages'=>array(
                    'jquery'=>array(
                        'baseUrl'=>'js/',
                        'js'=>array('jquery-1.10.1.min.js'),
                    )
                ),
                 'packages'=>array(
                    'main'=>array(
                        'baseUrl'=>'js/',
                        'js'=>array('main.js'),
                    )
                ),
            ),
//                'cache'=>array(
//                        'class'=>'system.caching.CMemCache',
//                        'servers'=>array(
//                            array('host'=>'localhost', 'port'=>11211, 'weight'=>60),
//                        ),
//                    ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(      
                
                ['api/<controller:\w+>/REST.OPTIONS', 'pattern'=>'api/<controller:\w+>/preflight', 'verb'=>'OPTIONS'],
                array('users/login', 'pattern'=>'api/users/login', 'verb'=>'POST'),
                'api/app/<action:\w+>'=>['api/app/<action>', 'verb'=>'GET'],
//                array('api/app/link', 'pattern'=>'api/app/link', 'verb'=>'GET'),
//                array('api/app/savedevice', 'pattern'=>'api/app/savedevice', 'verb'=>'GET'),
//                array('api/app/index', 'pattern'=>'api/app/index', 'verb'=>'GET'),
//                array('api/app/pushnotification', 'pattern'=>'api/app/pushnotification', 'verb'=>'GET'),                            
                array('api/solr', 'pattern'=>'api/solr', 'verb'=>'GET'),
                array('api/facebook', 'pattern'=>'api/facebook', 'verb'=>'GET'),
                array('api/facebook/login', 'pattern'=>'api/facebook/login', 'verb'=>'POST'),
                array('api/facebook/logout', 'pattern'=>'api/facebook/logout', 'verb'=>'GET'),
                            
                
                            
                'api/<controller:\w+>'=>['api/<controller>/REST.GET', 'verb'=>'GET'],
                'api/<controller:\w+>/<id:[\w\W]*>'=>['api/<controller>/REST.GET', 'verb'=>'GET'],
                'api/<controller:\w+>/<id:[\w\W]*>/<param1:[\w\W]*>'=>['api/<controller>/REST.GET', 'verb'=>'GET'],
                'api/<controller:\w+>/<id:[\w\W]*>/<param1:[\w\W]*>/<param2:[\w\W]*>'=>['api/<controller>/REST.GET', 'verb'=>'GET'],
             
                ['api/<controller>/REST.PUT', 'pattern'=>'api/<controller:\w+>/<id:\w*>', 'verb'=>'PUT'],
                ['api/<controller>/REST.PUT', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'PUT'],
                ['api/<controller>/REST.PUT', 'pattern'=>'api/<controller:\w*>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'PUT'], 
            
                ['api/<controller>/REST.DELETE', 'pattern'=>'api/<controller:\w+>/<id:\w*>', 'verb'=>'DELETE'],
                ['api/<controller>/REST.DELETE', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'DELETE'],
                ['api/<controller>/REST.DELETE', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'DELETE'],
            
                ['api/<controller>/REST.POST', 'pattern'=>'api/<controller:\w+>', 'verb'=>'POST'],
                ['api/<controller>/REST.POST', 'pattern'=>'api/<controller:\w+>/<id:\w+>', 'verb'=>'POST'],
                ['api/<controller>/REST.POST', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'POST'],
                ['api/<controller>/REST.POST', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'POST'],
            
                ['api/<controller>/REST.OPTIONS', 'pattern'=>'api/<controller:\w+>', 'verb'=>'OPTIONS'],
                ['api/<controller>/REST.OPTIONS', 'pattern'=>'api/<controller:\w+>/<id:\w+>', 'verb'=>'OPTIONS'],
                ['api/<controller>/REST.OPTIONS', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>', 'verb'=>'OPTIONS'],
                ['api/<controller>/REST.OPTIONS', 'pattern'=>'api/<controller:\w+>/<id:\w*>/<param1:\w*>/<param2:\w*>', 'verb'=>'OPTIONS'],
            
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                
                            
            ),
        ),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=DB',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'enableParamLogging' => true,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning,info',
//				),
//				// uncomment the following to show log messages on web pages
//				/*
//				array(
//					'class'=>'CWebLogRoute',
//				),
//				*/
//			),
//		),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'trace,info, error, warning',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => YII_DEBUG,
                    'levels' => 'error, warning, trace, notice',
                    'categories' => 'application',
                    'showInFireBug' => false,
                ),
            ),
        ),
        'image' => [
            'class' => 'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver' => 'GD',
        // ImageMagick setup path
        // 'params' => ['directory' => '/opt/local/bin'],
        ],
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'defaultRoles' => array('MANAGER', 'ADMIN', 'CLIENT', 'TECHNICIAN'),
        ),
    ),
    'aliases' => array(
        'RestfullYii' => realpath(__DIR__ . '/../extensions/starship/RestfullYii'),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'noreplay@snail.com',
        'solrUrl' => 'http URL',
        'salonImages'=>'/../images/',
        'salonRealImages'=>'/images/',
        'userImages'=>'/../userimages/',
        'userRealImages'=>'/userimages/',
    ),
);
