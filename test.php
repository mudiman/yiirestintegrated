<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST,PUT,DELETE,OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description,API_KEY,X_REST_CORS');
echo md5("test123");