<?php

namespace eff\modules\file\controllers;

use Yii;
use eff\components\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class AdminController
 * @package eff\modules\file\controllers
 */
class AdminController extends Controller
{
    public $modelClass = 'eff\modules\file\models\File';
    public $modelSearchClass = 'eff\modules\file\models\FileSearch';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'upload' => 'eff\modules\file\actions\Upload'
        ]);
    }

    public function actionAjax($id)
    {
        if (Yii::$app->request->isAjax) {
            $modelClass= $this->modelClass;
            $model = $modelClass::findOne($id);
            $data = $model->attributes;
            $data['date'] = date('d/m/Y H:i', $model->created_at);

            echo Json::encode($data);

        }
    }

    public function actionEmbed()
    {
        $this->layout = '/blank';

        // get model class
        $modelSearchClass = $this->modelSearchClass;

        // query to db
        $searchModel = new $modelSearchClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('embed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
