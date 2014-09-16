<?php

class UsersController extends MainController
{

    public function restEvents() {
        parent::restEvents();

//        $this->onRest('post.filter.model.find.all', function($result) {
//            foreach ($result as &$res) {
//                if ($res['profile_photo']!="")
//                    $res['profile_photo'] = Yii::app()->getBaseUrl(true) . $res['profile_photo'];
//            }
//            return $result;
//        });
        
        $this->onRest('model.find', function($model, $id) {
            if (Yii::app()->user->checkAccess('manager') || Yii::app()->request->getQuery('id')==Yii::app()->user->id)
                return $model->findByPk($id);
            else
                throw new CHttpException('400', CJSON::encode("Permmission denied"));
        });

        $this->onRest('model.find.all', function($model) {
            if (Yii::app()->user->checkAccess('manager')){
                return $model->findAll();
            }else
                throw new CHttpException('400', CJSON::encode("Permmission denied"));
        });

        $this->onRest('model.visible.properties', function() {
            return [];
        });

        $this->onRest('model.hidden.properties', function() {
            return ["password","authItems.type","authItems.type","authItems.data","authItems.description","authItems.bizrule"];
        });
        
        $this->onRest('model.save', function($model) {
            if (isset($model['profile_photo']) && preg_match("/http[s]*:\/\//i",$data['profile_photo'])==0){
                $filename=Helper::_saveImageFromBas64($model['profile_photo'],  Yii::app()->getBasePath().Yii::app()->params->userImages);
                $model['profile_photo']=  Yii::app()->getBaseUrl(true).Yii::app()->params->userRealImages."$filename";
            }
            $model->key=  md5(uniqid().$model->password);
            if(!$model->save()) {
                throw new CHttpException('400', CJSON::encode($model->errors));
            }
            $model->refresh();
            return $model;
        });
        
    }
}