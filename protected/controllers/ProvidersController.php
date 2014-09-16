<?php

class ProvidersController extends Controller {

    public $pagename = "Salons";

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function init() {
        $this->menu = array(
            array('label' => 'List Salons', 'url' => array('index')),
            array('label' => 'Create Salons', 'url' => array('create')),
//        array('label'=>'Manage Providers Services', 'url'=>array('manageservices')),
            array('label' => 'Manage Salons', 'url' => array('admin')),
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
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('view', 'index'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'create', 'update', 'manageservices'),
                'expression' => 'Yii::app()->user->checkAccess(\'manager\')'
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->pagename = "Create " . $this->pagename;

        $model = new Providers;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Providers'])) {
            $model->attributes = $_POST['Providers'];
            $this->uploadImageAndUpdateModel($model);
            if ($model->save()) {
                $worker = new Workers;
                $worker->users_id = Yii::app()->user->id;
                $worker->providers_id = $model->id;
                $worker->working_plan = "{}";
                if ($worker->save())
                    $this->redirect(array('view', 'id' => $model->id));
                else {
                    print_r($worker->getError(true));
                }
            }
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
        $this->pagename = "Update " . $this->pagename;
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Providers'])) {
            $model->attributes = $_POST['Providers'];
            if ($model->save()){
                $this->uploadImageAndUpdateModel($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
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

    public function actionManageservices($id) {
        $this->pagename = "Manage " . $this->pagename . " Services";
        
        if (isset($_POST['serviceid'])) {
            $serviceids = $_POST['serviceid'];
            $servicecosts = $_POST['servicecost'];
            for ($i = 0; $i < count($serviceids); $i++) {
                $newservice = new ServicesProviders();
                $ser=ServicesProviders::model()->find("providers_id=$id and services_id=$serviceids[$i]");
                if ($ser)
                    $newservice=$ser;
                $newservice->providers_id = $id;
                $newservice->services_id = $serviceids[$i];
                $newservice->cost = $servicecosts[$i];
                if ($newservice->save()) {
                    echo "success";
                } else {
                    print_r($newservice->getError(true));
                    echo "failed";
                }
            }
        }
        $services = Services::model()->findAll();
        $provider_services = ServicesProviders::model()->findAll("providers_id=$id");
        var_dump(count($provider_services));
        $res = array();
        foreach ($services as $service) {
            $temp = array();
            $temp['id'] = $service['id'];
            $temp['name'] = $service['name'];
            $temp['cost'] = "";
            $temp['checked'] = false;
            $temp['duration'] = "";
            $temp['description'] = "";
            foreach ($provider_services as $provider_service) {
                if ($service['id'] == $provider_service['services_id']) {
                    $temp['cost'] = $provider_service['cost'];
                    $temp['checked'] = true;
                    $temp['duration'] = $provider_service['duration'];
                    $temp['description'] = $provider_service['description'];
                    break;
                } 
            }
            $res[] = $temp;
        }
        //var_dump($res);
        $this->render('managerservice', array(
            'services' => $res,
            'providerid' => $id
        ));
    }
    
    private function uploadImageAndUpdateModel($model){
        $model->profile_image = CUploadedFile::getInstance($model, 'profile_image');
        if ($model->profile_image){
            $filename= md5(strtotime("now").$model->profile_image->getName()).".".$model->profile_image->getExtensionName();
            $model->profile_image->saveAs(Yii::app()->getBasePath(true) . Yii::app()->params->salonImages. $filename);
            $model->profile_photo=$filename;
            $model->save();
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $dataProvider = new CActiveDataProvider('Providers', array(
            'criteria' => array(
                'condition' => "id in (select providers_id from workers where users_id=" . Yii::app()->user->id . ")",
                'order' => 'id'
            ), 'pagination' => array(
                'pageSize' => 10,
            )
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->pagename = "Manage " . $this->pagename;
        $model = new Providers('search');
        $model->unsetAttributes();  // clear any default values

        $dataProvider = new CActiveDataProvider('Providers', array(
            'criteria' => array(
                'condition' => "id in (select providers_id from workers where users_id=" . Yii::app()->user->id . ")",
                'order' => 'id'
            ), 'pagination' => array(
                'pageSize' => 10,
            )
        ));

        if (isset($_GET['Providers']))
            $model->attributes = $_GET['Providers'];

        $this->render('admin', array(
            'model' => $model, 'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Providers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Providers::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Providers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'providers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
