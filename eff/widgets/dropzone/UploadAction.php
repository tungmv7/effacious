<?php

namespace eff\widgets\dropzone;

use eff\modules\file\models\File;
use Yii;
use yii\base\Action;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\web\UploadedFile;

class UploadAction extends Action
{
    public $fileName = 'file';
    public $basePath;
    public $rootDir;

    public $afterUploadHandler = null;
    public $afterUploadData = null;

    protected $uploadDir = '';
    protected $uploadSrc = '';

    public function init()
    {
        parent::init();

        if (empty($this->rootDir)) {
            $this->rootDir = Yii::getAlias('@files');
        }

        $this->uploadDir = $this->rootDir;
    }

    public function afterRun()
    {
        $data = $this->afterUploadData;

        // save to db
        $file = new File();
        $file->loadDefaultValues();
        $file->base_path = isset($data['params']['basePath']) ? $data['params']['basePath'] : 'a';
        $file->base_url =isset($data['params']['baseUrl']) ? $data['params']['baseUrl'] : 'b';
        $file->file = $data['file']->name ;
        $file->name = $data['file']->baseName;
        $file->type = $data['file']->type;
        if ($file->save()) {
            echo Json::encode(['filename' => $file->name]);
        } else {
            echo Json::encode(['errors' => $file->getErrors()]);
        }
    }

    public function run()
    {
        $file = UploadedFile::getInstanceByName($this->fileName);
        if ($file->hasError) {
            throw new HttpException(500, 'Upload error');
        }

        if (Yii::$app->request->post('basePath', false) === false) {
            throw new InvalidParamException("The basePath parameter is required.");
        }

        if (Yii::$app->request->post('baseUrl', false) === false) {
            throw new InvalidParamException("The baseUrl parameter is required.");
        }

        $fileName = $file->name;
        if (file_exists($this->uploadDir . DIRECTORY_SEPARATOR . $fileName)) {
            $fileName = $file->baseName . '-' . uniqid() . '.' . $file->extension;
        }
        $file->saveAs($this->uploadDir . DIRECTORY_SEPARATOR . $fileName);
        $this->afterUploadData = [
            'file' => $file,
            'params' => Yii::$app->request->post()
        ];
    }
}
