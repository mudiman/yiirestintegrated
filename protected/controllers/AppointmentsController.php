<?php

class AppointmentsController extends Controller
{
	public $pagename="Appointments";
        /**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        
        public function init(){
            $this->menu=array(
                    array('label'=>'Create Appointments', 'url'=>array('create')),
                    array('label'=>'Manage Appointments', 'url'=>array('admin')),
            );
        }
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            //'expression'=>array('AppointmentsController','allowOnlyOwner')
		return array(
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
                                'users'=>array('@'),
			),
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('indexadmin'),
                                //'users'=>array('@'),
                                'expression'=>'Yii::app()->user->checkAccess(\'manager\')'
			),
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('indextechnician','view'),
                                'expression'=>'($user->role==\'technician\')'
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('indexclient','view'),
                                'expression'=>'($user->role==\'client\')'
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function allowOnlyOwner(){
            echo Yii::app()->user->role;exit();
        if(Yii::app()->user->role=="admin"){
            return true;
        }
        else{
            return false;
        }
    }
    
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $this->pagename="Create ".$this->pagename;
		$model=new Appointments;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Appointments']))
		{
			$model->attributes=$_POST['Appointments'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
                if (isset($_GET['appointmentdate']))
                    $model->start_datetime=$_GET['appointmentdate'];
		$this->render('create',array(
			'model'=>$model,
                        'providers_array' => CMap::mergeArray(array("" => ""), 
                                CHtml::listData(Providers::model()->findAll("id in (select providers_id from workers where users_id=".
                                        Yii::app()->user->id.")"), "id", 'name')),
                        'services_array' => CMap::mergeArray(array("" => ""), 
                                CHtml::listData(Services::model()->findAll(), "id", 'name')),
                        'workers_array' => CMap::mergeArray(array("" => ""), 
                                CHtml::listData(Users::model()->findAll('id in (select userid from AuthAssignment where '
                                        . 'itemname="technician" and userid in '
                                        . '(select users_id from workers where providers_id in '
                                        . '(select providers_id from workers where users_id='.Yii::app()->user->id.')))'), "id", 'email')),
                        'users_array' => CMap::mergeArray(array("" => ""), 
                                CHtml::listData(Users::model()->findAll('id in (select userid from AuthAssignment where '
                                        . 'itemname="client")'), "id", 'email')),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Appointments']))
		{
			$model->attributes=$_POST['Appointments'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

        /**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
                if (isset(Yii::app()->user->role)){
                    if (in_array(Yii::app()->user->role,array("manager","admin")))
                        $this->redirect(Yii::app ()->baseUrl.'/appointments/indexadmin');
                    elseif (Yii::app()->user->role=="client")
                        $this->redirect(Yii::app ()->baseUrl.'/appointments/indexclient');
                    elseif (Yii::app()->user->role=="technician")
                        $this->redirect(Yii::app ()->baseUrl.'/appointments/indextechnician');
                }
	}
	/**
	 * Lists all models.
	 */
	public function actionIndexadmin()
	{
		$dataProvider=new CActiveDataProvider('Appointments');
		$this->render('indexadmin',array(
			'dataProvider'=>$dataProvider,
		));
	}
        
        /**
	 * Lists all models.
	 */
	public function actionIndexclient()
	{
		$dataProvider=new CActiveDataProvider('Appointments');
		$this->render('indexclient',array(
			'dataProvider'=>$dataProvider,
		));
	}
        
        /**
	 * Lists all models.
	 */
	public function actionIndextechnician()
	{
		$dataProvider=new CActiveDataProvider('Appointments');
		$this->render('indextechnician',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Appointments('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Appointments']))
			$model->attributes=$_GET['Appointments'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Appointments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Appointments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Appointments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='appointments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
