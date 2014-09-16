<?php

class MainController extends Controller {

    private $_identity;

    public function filters() {

        return array('accessControl', // perform access control for CRUD operations
            array('ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE, REST.OPTIONS'),);
    }

    public function actions() {

        return array('REST.' => 'ext.starship.RestfullYii.actions.ERestActionProvider',);
    }

    public function accessRules() {
        
        return array(
            array('allow',
                'actions' => array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE', 'REST.OPTIONS'),
                'users' => array('*')),
            array('allow', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function restEvents() {
        $this->onRest('req.param.is.pk', function($pk) {
            //return $pk === '0' || preg_match('/^-?[1-9][0-9]*$/', $pk) === 1;
            return $pk === '0' || preg_match('/\w+/', $pk) === 1;
        });
        $this->onRest('req.exception', function($errorCode, $message = null) {
            $this->renderJSON([
                'type' => 'error',
                'success' => false,
                'message' => (is_null($message) ? $this->getHttpStatus()->message : $message),
                'errorCode' => $errorCode,
            ]);
        });

        $this->onRest('req.event.logger', function($event, $category = 'application', $ignore = []) {
            if (!isset($ignore[$event])) {
                Yii::trace($event, $category);
            }
            return [$event, $category, $ignore];
        });


        $this->onRest('req.auth.ajax.user', function() {

            if ($this->getHeaders("API_KEY") == NULL) {
                return false;
            }
            $user_key = $this->getHeaders("API_KEY");
            $this->_identity = new UserIdentity(null, null, $user_key);
            $test = $this->_identity->authenticate();
            Yii::app()->user->login($this->_identity);
            if ($test) {
                return true;
            } else
                return false;
        });

        $this->onRest('req.auth.type', function($application_id) {
            //$header=getallheaders();
            if (isset($_SERVER['X_' . $application_id . '_CORS']) || (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS')) {
                return ERestEventListenerRegistry::REQ_TYPE_CORS;
            } else if (isset($_SERVER['HTTP_X_' . $application_id . '_USERNAME']) && isset($_SERVER['HTTP_X_' . $application_id . '_PASSWORD'])) {
                return ERestEventListenerRegistry::REQ_TYPE_USERPASS;
            } else {
                return ERestEventListenerRegistry::REQ_TYPE_AJAX;
            }
        });

        $this->onRest('req.cors.access.control.allow.origin', function() {

            return ["*"]; //List of sites allowed to make CORS requests 
        });
        $this->onRest('post.filter.req.cors.access.control.allow.origin', function($allowed_origins) {
            return $allowed_origins; //Array
        });

        $this->onRest('req.cors.access.control.allow.headers', function($application_id) {
            return ["Content-Type", "Content-Range", "Content-Disposition", "Content-Description", "API_KEY", "X_REST_CORS"];
        });


        $this->onRest('req.auth.cors', function ($allowed_origins) {
            return true;
        });

        $this->onRest('req.cors.access.control.allow.methods', function() {
            return ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS']; //List of allowed http methods (verbs) 
        });

        $this->onRest('req.after.action', function($filterChain) {
            //Logic being applied after the action is executed
            Yii::app()->user->logout();
        });

        $this->onRest('post.filter.req.auth.ajax.user', function($validation) {
            if (!$validation) {
                return false;
            }
            //var_dump(Yii::app()->request->getQuery('id'));
            switch ($this->getAction()->getId()) {
                case 'REST.GET':
                    return Yii::app()->user->checkAccess('REST-GET');
                    break;
                case 'REST.POST':
                    // By pass permission issues
//                    if (Yii::app()->controller->id == "users" && Yii::app()->request->isPostRequest)
//                        return Yii::app()->user->checkAccess('REST-USER-CREATE');
//                    else
//                        return Yii::app()->user->checkAccess('REST-CREATE');
                    return true;
                    break;
                case 'REST.PUT':
                    return Yii::app()->user->checkAccess('REST-UPDATE');
                    break;
                case 'REST.DELETE':
                    return Yii::app()->user->checkAccess('REST-DELETE');
                    break;
                default:
                    return false;
                    break;
            }
        });

        $this->onRest('req.data.read', function($stream = 'php://input') {

            $reader = new ERestRequestReader($stream);
            $json = $this->_validate_json($reader->getContents());
            //return CJSON::decode($json);
            return $json;
        });

        $this->onRest('req.get.resources.render', function($data, $model_name, $relations, $count, $visibleProperties = [], $hiddenProperties = []) {
            //Handler for GET (list resources) request
            $this->setHttpStatus((($count > 0) ? 200 : 200));
            $this->renderJSON([
                'type' => 'rest',
                'success' => (($count > 0) ? true : true),
                'message' => (($count > 0) ? "Record(s) Found" : "No Record(s) Found"),
                'totalCount' => $count,
                'modelName' => $model_name,
                'relations' => $relations,
                'visibleProperties' => $visibleProperties,
                'hiddenProperties' => $hiddenProperties,
                'data' => $data,
            ]);
        });
    }

    function getHeaders($key) {
        $headers = getallheaders();
        if (isset($headers[$key])) {
            return $headers[$key];
        } else {
            return FALSE;
        }
    }

    public function _validate_json($json) {

        $json = CJSON::decode($json);
        if ($json == null || count($json) == 0) {
            $error = "Syntax error, malformed JSON.";
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

            throw new CHttpException('400', CJSON::encode($error));
        }
        return $json;
    }

    public function _saveImageFromBas64($base64) {
        $decoded = base64_decode($base64);
        $path = realpath(Yii::app()->basePath . "/../images");

        $file_name = uniqid() . ".jpeg";
        file_put_contents($path . "/" . $file_name, $decoded);
        return Yii::app()->request->baseUrl . "/images/$file_name";
    }
}
