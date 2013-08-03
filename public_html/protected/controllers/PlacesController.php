<?php
class PlacesController extends RestController
{
    public function actionIndex() {
        if (Yii::app()->user->checkAccess('user')) {
            $this->render('index');
        }
        else {
            $this->redirect(array('site/login'));
        }
    }

    public function actionList()
    {
        if (!Yii::app()->user->checkAccess('user')) {
            $this->_sendResponse(403);
            return;
        }
        //searching only for current users places (defaultScope returns appropriate condition)
        $places = Places::model()->findAll();
        echo CJSON::encode($places);
    }

    public function actionView($id)
    {
        // TODO: Implement actionView() method.
    }

    public function actionCreate()
    {
        if (!Yii::app()->user->checkAccess('user')) {
            $this->_sendResponse(403);
            return;
        }
        $data = CJSON::decode(file_get_contents('php://input'));
        $place = new Places();
        $place->p_title = $data['p_title'];
        $place->p_description = isset($data['p_description']) ? $data['p_description'] : '';
        $place->p_lng = $data['p_lng'];
        $place->p_lat = $data['p_lat'];
        if ($place->save()) {
            $this->_sendResponse(200, CJSON::encode($place));
        }
        else {
            $this->_sendResponse(500, CJSON::encode(array(
                'message'=>'Could not save place',
                'errors'=>$place->getErrors(),
            )));
        }
    }

    public function actionUpdate($id)
    {
        $data = CJSON::decode(file_get_contents('php://input'));
        $place = Places::model()->findByPk($id);
        if (!Yii::app()->user->checkAccess('user', array('place'=>$place))) {
            $this->_sendResponse(403);
            return;
        }
        if (null === $place) {
            $this->_sendResponse(404, CJSON::encode(array('message'=>'Could not find place with id = '.$id)));
        }
        $place->p_title = $data['p_title'];
        $place->p_description = isset($data['p_description']) ? $data['p_description'] : '';
        $place->p_lng = $data['p_lng'];
        $place->p_lat = $data['p_lat'];
        if ($place->save()) {
            $this->_sendResponse(200, CJSON::encode($place));
        }
        else {
            $this->_sendResponse(500, CJSON::encode(array(
                'message'=>'Could not save place',
                'errors'=>$place->getErrors(),
            )));
        }
    }

    public function actionDelete($id)
    {
        $place = Places::model()->findByPk($id);
        if (null === $place) {
            $this->_sendResponse(404, CJSON::encode(array('message'=>'Could not find place with id = '.$id)));
            return;
        }
        if (!Yii::app()->user->checkAccess('user', array('place'=>$place))) {
            $this->_sendResponse(403);
            return;
        }
        if ($place->delete()) {
            $this->_sendResponse(200, CJSON::encode($place));
        }
        else {
            $this->_sendResponse(500, CJSON::encode(array(
                'message'=>'Could not delete place',
                'errors'=>$place->getErrors(),
            )));
        }
    }
}