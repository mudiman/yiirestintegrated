<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NormalController
 *
 * @author mudassar
 */
class NormalController extends Controller {

    //put your code here
    private $_identity;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        if ($this->getHeaders("API_KEY") == NULL) {
            $this->__sendResponse(401,false,"Unauthorized","Unauthorized");
        }
        $user_key = $this->getHeaders("API_KEY");
        $this->_identity = new UserIdentity(null, null, $user_key);
        $test = $this->_identity->authenticate();
        if (!$test) {
            $this->__sendResponse(401,false,"Unauthorized","Unauthorized");
        } else {
            Yii::app()->user->login($this->_identity);
        }
    }

    public function filters() {

        return array('accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function getHeaders($key) {
        $headers = getallheaders();
        if (isset($headers[$key])) {
            return $headers[$key];
        } else {
            return FALSE;
        }
    }
    
    public function __sendResponse($statuscode,$status,$messageheader,$messagebody){
        echo CJSON::encode($this->__setResponse($statuscode,$status,$messageheader,$messagebody));
        Yii::app()->end();
    }
    
    public function __setResponse($statuscode,$status,$messageheader,$messagebody){
        header('Content-type: application/json');
        $status_header = "HTTP/1.1 ".strval($statuscode);
        header($status_header);
        $status=$status?"true":"false";
        if ($statuscode!=200)
            $data=CJSON::decode("{success: $status,message: '$messageheader',data: {errorCode: ".strval($statuscode).",message: '$messagebody'}}");
        else
            $data=CJSON::decode("{success: $status,message: '$messageheader',data: $messagebody}");
        return $data;
    }
       
    public function validate_json($json) {
        
        $json = CJSON::decode($json);
        
        if ($json == null || count($json) == 0) {
            throw new Exception("Syntax error, malformed JSON.");
        }
        
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid
                break;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // only PHP 5.3+
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }
        if ($error != "") {
            throw new Exception($error);
        }
        return $json;
    }
}
