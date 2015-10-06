<?php
namespace eff\actions;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class Create extends Action
{
    // redirect url
    public $redirect = ['view'];

    // view file
    public $view = 'create';


    public function run()
    {
        // get model class
        $modelClass = $this->getModelClass();

        // create new model
        $model = new $modelClass;

        // load model default values
        $model->loadDefaultValues();

        // load post values to model
        if ($model->load(Yii::$app->request->post())) {

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            // save and redirect if successful
            if ($model->save()) {
                return $this->controller->redirect(ArrayHelper::merge($this->redirect, $model->getPrimaryKey(true)));
            }
        }

        // render to view
        return $this->controller->render($this->view, [
            'model' => $model,
        ]);

    }

}