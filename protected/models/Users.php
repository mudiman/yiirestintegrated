<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile_photo
 * @property string $created_at
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property string $phone_number
 * @property string $address
 * @property string $city
 * @property string $zip_code
 * @property integer $status
 * @property string $comments
 * @property string $hash_key
 * @property string $key
 *
 * The followings are the available model relations:
 * @property AuthItem[] $authItems
 * @property Appointments[] $appointments
 * @property Workers[] $workers
 */
class Users extends CActiveRecord
{
        public $password_repeat;
        public $oldPassword;
        public $profile_image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
                        array('password', 'required','on' => 'createUser'),
                    
			array('status', 'numerical', 'integerOnly'=>true),
			array('username, email, mobile_number, phone_number', 'length', 'max'=>100),
			array('zip_code, key', 'length', 'max'=>45),
                        array('email', 'email','message'=>"The email isn't correct"),
                    
                        array('password,password_repeat', 'required','on' => 'createUser'),
                        array('password, password_repeat', 'length', 'min'=>6, 'max'=>40),
                        array('password', 'compare', 'compareAttribute'=>'password_repeat','on' => 'createUser'),
                    
			array('first_name, last_name, city', 'length', 'max'=>1000),
			array('profile_photo,profile_image, created_at, address, comments, hash_key', 'safe'),
                        array('profile_photo,profile_image', 'safe'),
                        array('profile_image', 'file', 'types'=>'jpg,png,gif,bmp,jpeg','on' => 'imageUpload'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, profile_photo, created_at, first_name, last_name, mobile_number, phone_number, address, city, zip_code, status, comments, hash_key, key', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'authItems' => array(self::MANY_MANY, 'AuthItem', 'AuthAssignment(userid, itemname)'),
			'appointments' => array(self::HAS_MANY, 'Appointments', 'users_id'),
			'workers' => array(self::HAS_MANY, 'Workers', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'profile_photo' => 'Profile Photo',
			'created_at' => 'Created At',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'mobile_number' => 'Mobile Number',
			'phone_number' => 'Phone Number',
			'address' => 'Address',
			'city' => 'City',
			'zip_code' => 'Zip Code',
			'status' => 'Status',
			'comments' => 'Comments',
			'hash_key' => 'Hash Key',
			'key' => 'Key',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('profile_photo',$this->profile_photo,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('mobile_number',$this->mobile_number,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('hash_key',$this->hash_key,true);
		$criteria->compare('key',$this->key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
