<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of staging
 *
 * @author mudassar
 */

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'), 
    array(
        'components'=>array(
           'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=DB',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		),
        ),
    )
);

