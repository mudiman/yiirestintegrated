<?php

class WorkersController extends MainController
{
    public function restEvents() {
        parent::restEvents();

//        $this->onRest('post.filter.model.find.all', function($result) {
//            foreach ($result as &$res) {
//                if ($res['providers']['profile_photo']!="")
//                        $res['providers']['profile_photo'] = Yii::app()->getBaseUrl(true) ."/images/". $res['providers']['profile_photo'];
//                if ($res['users']['profile_photo']!="")
//                        $res['users']['profile_photo'] = Yii::app()->getBaseUrl(true) ."/images/". $res['users']['profile_photo'];
//            }
//            return $result;
//        });
    }
}