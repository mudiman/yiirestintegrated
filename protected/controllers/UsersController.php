<?php

class UsersController extends Controller {

    public $pagename = "User";

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function init() {
        $this->menu = array(
            array('access' => 'all', 'label' => 'Update record', 'url' => array("users/update/" . Yii::app()->user->id)),
        );
    }

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'create'
                'actions' => array('create'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'view', 'index'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'createtechnician'),
                'expression' => 'Yii::app()->user->checkAccess(\'manager\')'
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    
    private function uploadImageAndUpdateModel($model){
        $model->profile_image = CUploadedFile::getInstance($model, 'profile_image');
        if ($model->profile_image){
            $filename= md5(strtotime("now").$model->profile_image->getName()).".".$model->profile_image->getExtensionName();
            $model->profile_image->saveAs(Yii::app()->getBasePath(true) . Yii::app()->params->userImages. $filename);
            $model->profile_photo=$filename;
            $model->save();
        }
    }
    
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        if (Yii::app()->user->id == $id || Yii::app()->user->checkaccess('manager'))
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        else {
            //$error=array("code"=>"403","message"=>"Unauthorized");

            throw new CHttpException(403, 'Unauthorized.');

            //$this->redirect(Yii::app ()->baseUrl.'/site/error', $error);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreatetechnician() {

        $this->pagename = "Register Technician " . $this->pagename;
        $model = new Users;
        $modelprovider = new Providers;
        $transaction = $model->getDbConnection()->beginTransaction();

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $temp = $_POST['Providers'];
            try {
                if ($model->save()) {
                    $authmodel = new AuthAssignment();
                    //$transactionauth=$authmodel->getDbConnection()->beginTransaction();

                    $authmodel->itemname = 'technician';
                    $authmodel->userid = $model->id;

                    if ($authmodel->save()) {
                        $worker = new Workers();
                        //$transactionWorker=$worker->getDbConnection()->beginTransaction();
                        $worker->users_id = $model->id;
                        $worker->providers_id = $temp['id'];
                        if ($worker->save()) {
                            $transaction->commit();
                            //$transactionauth->commit();
                            //$transactionWorker->commit();
                            $this->redirect(array('view', 'id' => $model->id));
                        } else {
                            //$transaction->rollback();
                            //$transactionauth->rollback();
                            //$transactionWorker->rollback();
                        }
                    } else {
                        $transaction->rollback();
                    }
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }

        $this->render('createTechnician', array(
            'model' => $model,
            'modelprovider' => $modelprovider,
            'providers_array' => CMap::mergeArray(array("" => ""), CHtml::listData(Providers::model()->findAll("id in (select providers_id from workers where users_id=" .
                                    Yii::app()->user->id . ")"), "id", 'name')),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->pagename = "Register " . $this->pagename;
        $model = new Users('createUser');
        $transaction = $model->getDbConnection()->beginTransaction();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $oldpassword = $model->password;
            $user = Users::model()->find('email=:email and status=0', array(':email' => $model->email));
            if ($user)
                $model = $user;
            $model->password=$oldpassword;
            $model->password_repeat=$oldpassword;
            $model->status = 1;
            $model->password = md5(trim($model->password));
            $model->key = $model->password;
            $model->password_repeat = $model->password;
            //try {
            if ($model->save()) {
                if (!$user) {
                    $authmodel = new AuthAssignment();
                    $authmodel->itemname = 'manager';
                    $authmodel->userid = $model->id;
                }
                if ($user || $authmodel->save()) {
                    $transaction->commit();
                    $identity = new UserIdentity($model->email, $model->password);
                    $identity->authenticate();
                    Yii::app()->user->login($identity, 0);
                    if (Yii::app()->user->IsGuest) {
                        $this->redirect(Yii::app()->baseUrl . '/site/login');
                    }
                    $this->redirect(Yii::app()->baseUrl . '/appointments/index');
                    //$this->redirect(array('view', 'id' => $model->id));
                } else {
                    $transaction->rollback();
                    $model->password = $oldpassword;
                    $model->password_repeat = $oldpassword;
                }
            }
//                } catch (Exception $e) {
//                    $transaction->rollback();
//                    $model->password=$oldpassword;
//                    $model->password_repeat=$oldpassword;
//                }
            //}
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->password=md5($model->password);
            if ($model->save()){
                $this->uploadImageAndUpdateModel($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
                //'services' => CMap::mergeArray(array("" => ""), CHtml::listData(Services::model()->findAll("id in (select providers_id from workers where users_id=" .
                //                      Yii::app()->user->id . ")"), "id", 'name')),
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Users');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Users']))
            $model->attributes = $_GET['Users'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
