<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Snail',

	// preloading 'log' component
	'preload'=>array('log'),
    
        'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.libraries.*',
                'application.components.feedparsers.*',
                'application.config.Constants',
	),

	// application components
	'components'=>array(
            'email'=>array(
                'class'=>'application.extensions.email.Email',
                'delivery'=>'php', //Will use the php mailing function.  
                //May also be set to 'debug' to instead dump the contents of the email into the view
            ),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=snail',
			'emulatePrepare' => true,
			'username' => 'sovoia',
			'password' => 'sovoia123',
			'charset' => 'utf8',
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
        'params' => array(
           // this is used in contact page
           'adminEmail' => 'noreplay@snail.com',
           'solrUrl' => 'http://localhost:8080/wearplay',

       ),
);