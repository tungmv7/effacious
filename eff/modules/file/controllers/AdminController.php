<?php

namespace eff\modules\file\controllers;

use Yii;
use eff\components\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
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

            $file = [
                'id' => $model->id,
                'filename' => $model->filename,
                'extension' => $model->extension,
                'type' => $model->type,
                'name' => $model->name,
                'title' => $model->name,
                'alt' => '',
                'description' => $model->description,
                'thumbnail' => $model->thumbnail,
                'path' => $model->path,
                'url' => Yii::$app->params['staticDomain'] . $model->url

            ];
            $file['date'] = date('d/m/Y', $model->created_at);

            if (@unserialize($model->meta_data)) {
                $rawData = unserialize($model->meta_data);
                $metadata['size'] = self::convertFilesize($rawData['FileSize']);
                if (isset($rawData["COMPUTED"]["Height"]) && isset($rawData["COMPUTED"]["Width"])) {
                    $metadata['resolution'] = [
                        'h' => $rawData['COMPUTED']['Height'],
                        'w' => $rawData['COMPUTED']['Width']
                    ];
                }
                $file['metadata'] = $metadata;
            }

            echo Json::encode($file);

        }
    }

    private static function convertFilesize($size)
    {
        $size = max(0, (int)$size);
        $units = array( 'b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb', 'Eb', 'Zb', 'Yb');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' .$units[$power];
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
