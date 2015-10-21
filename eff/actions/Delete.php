<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 4:23 PM
 */

namespace eff\actions;


use yii\helpers\Json;

class Delete extends Action
{
    public $deleteType = 'softDelete';

    // view file
    public $redirect = ['index'];

    // model class
    public $modelClass;

    public function run($id)
    {
        // get model class
        $modelClass = $this->getModelClass();

        // delete model data
        $deleteFunction = $this->deleteType;
        $modelClass::findOne($id)->$deleteFunction();

        // render to view
        if (\Yii::$app->request->isAjax) {
            echo Json::encode('success', 200);
        } else {
            return $this->controller->redirect($this->redirect);
        }

    }

}