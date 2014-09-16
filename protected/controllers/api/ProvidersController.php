<?php

class ProvidersController extends MainController
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
     
        $this->onRest('model.save', function($model) {
            if (isset($model['profile_photo']) && preg_match("/http[s]*:\/\//i",$data['profile_photo'])==0){
                $filename=Helper::_saveImageFromBas64($model['profile_photo'],  Yii::app()->getBasePath().Yii::app()->params->salonImages);
                $model['profile_photo']=  Yii::app()->getBaseUrl(true).Yii::app()->params->salonRealImages."$filename";
            }
            if(!$model->save()) {
                throw new CHttpException('400', CJSON::encode($model->errors));
            }
            $model->refresh();
            return $model;
        });
    }

}