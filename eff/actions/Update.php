<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 3:20 PM
 */

namespace eff\actions;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class Update extends Action
{
    // redirect url
    public $redirect = ['update'];

    // view file
    public $view = 'update';


    public function run($id)
    {
        // get model class
        $modelClass = $this->getModelClass();

        // find model data
        $model = $modelClass::findOne($id);

        // load post values to model
        if ($model->load(Yii::$app->request->post())) {

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            // save and redirect if successful
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('eff', 'Updated successfully.'));
                return $this->controller->redirect(ArrayHelper::merge($this->redirect, $model->getPrimaryKey(true)));
            }
        }

        // render to view
        return $this->controller->render($this->view, [
            'model' => $model,
        ]);

    }

}