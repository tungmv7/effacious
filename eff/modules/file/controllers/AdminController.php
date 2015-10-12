<?php

namespace eff\modules\file\controllers;

use eff\components\Controller;
use yii\helpers\ArrayHelper;

class AdminController extends Controller
{
    public $modelClass = 'eff\modules\file\models\File';
    public $modelSearchClass = 'eff\modules\file\models\FileSearch';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'upload' => 'eff\widgets\dropzone\UploadAction',
            'remove' => 'eff\widgets\dropzone\RemoveAction'
        ]);
    }

}
