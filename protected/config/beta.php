<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'), 
    array(
        'components'=>array(
           'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=wearxplay',
			'emulatePrepare' => true,
			'username' => 'sovoia',
			'password' => '1qaz2wsx0okm9ijn',
			'charset' => 'utf8',
		),
        ),
        'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
                'solrUrl'=>'http://localhost:8889/wearplay',
	),
    )
);