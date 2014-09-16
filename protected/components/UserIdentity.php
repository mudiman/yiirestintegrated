<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
//	public function authenticate()
//	{
//		$users=array(
//			// username => password
//			'demo'=>'demo',
//			'admin'=>'admin',
//		);
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		elseif($users[$this->username]!==$this->password)
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
//	}

    private $_id;
    private $key;
    private $email;
    private $user;
    
    public function __construct($email=null,$password=null,$key=null)
    {
        if (isset($email) && isset($password)){
            $this->email=$email;
            $this->password=$password;
        }else
            $this->key=$key;
    }

    public function authenticate() {
        if (isset($this->key))
            $record = Users::model()->findByAttributes(array('key' => $this->key));
        else
            $record = Users::model()->findByAttributes(array('email' => $this->email));
        
        $status=false;
        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (isset($this->password) && $record->password !== md5($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $record->id;
            $this->user=$record;
            $this->setState('email', $record->email);
//            $this->setState('name', $record->username);
            $this->setState('id', $record->id);
//            $this->setState('key', $record->key);
            
            $auth=Yii::app()->authManager;
            $data = AuthAssignment::model()->find('userid=:userid',array(':userid'=>$record->id));
            $this->setState('role', $data->itemname);
            //echo  Yii::app()->user->role;exit();
            $this->errorCode = self::ERROR_NONE;
            $status=true;
        }
        return $status;
    }

    public function getId() {
        return $this->_id;
    }
    
    public function getUser(){
        return $this->user;
    }

}
