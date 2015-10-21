<?php

namespace eff\modules\file\actions;

use eff\modules\file\models\File;

use Yii;
use yii\base\Action;
use yii\base\InvalidValueException;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\UploadedFile;

class Upload extends Action
{
    public $fileName = 'file';
    public $afterUploadData = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $file = UploadedFile::getInstanceByName($this->fileName);
        if ($file->hasError) {
            throw new HttpException(500, 'Upload error');
        }

        if (Yii::$app->has('fileStorage')) {

            // get temp file bucket
            $tempBucket = Yii::$app->fileStorage->getBucket('tempFiles');
            // TODO: validate file type

            $fileBaseName = Inflector::slug($file->baseName);
            if ($tempBucket->fileExists($fileBaseName . '.' . $file->extension)) {
                $fileBaseName = $fileBaseName . '-' . uniqid();
            }

            // save to temp folder
            if ($tempBucket->moveFileIn($file->tempName, $fileBaseName . '.' . $file->extension)) {

                if (strpos($file->type, 'image') === 0) {
                    $bucket = Yii::$app->fileStorage->getBucket('imageFiles');
                } elseif (strpos($file->type, 'video') === 0) {
                    $bucket = Yii::$app->fileStorage->getBucket('videoFiles');
                } elseif (strpos($file->type, 'audio') === 0) {
                    $bucket = Yii::$app->fileStorage->getBucket('audioFiles');
                } elseif (strpos($file->type, 'text') === 0) {
                    $bucket = Yii::$app->fileStorage->getBucket('textFiles');
                } elseif (strpos($file->type, 'application') === 0) {
                    $bucket = Yii::$app->fileStorage->getBucket('applicationFiles');
                } else {
                    $tempBucket->deleteFile($fileBaseName . '.' . $file->extension);
                    throw new InvalidValueException("This file type '".$file->type."' is not supported.");
                }

                // move to storage
                if ($bucket->moveFileInternal(['tempFiles', $fileBaseName . '.' . $file->extension], [$bucket->name, $fileBaseName . '.' . $file->extension])) {

                    $this->afterUploadData = [
                        'file' => [
                            'name' => $fileBaseName . '.' . $file->extension,
                            'baseName' => $fileBaseName,
                            'type' => $file->type,
                            'extension' => $file->extension
                        ],
                        'path' => $bucket->getBaseSubPath() . DIRECTORY_SEPARATOR . $bucket->getFileNameWithSubDir($fileBaseName . '.' . $file->extension),
                        'url' => $bucket->getFileUrl($fileBaseName . '.' . $file->extension),
                        'storage' => 'local',
                        'params' => Yii::$app->request->post()
                    ];


                    // save to db
                    $fileDb = new File();
                    $fileDb->loadDefaultValues();
                    $fileDb->path = $this->afterUploadData['path'];
                    $fileDb->url = $this->afterUploadData['url'];
                    $fileDb->filename = $this->afterUploadData['file']['name'];
                    $fileDb->name = $this->afterUploadData['file']['baseName'];
                    $fileDb->type = $this->afterUploadData['file']['type'];
                    $fileDb->extension = $this->afterUploadData['file']['extension'];
                    if (isset($this->afterUploadData['storage'])) {
                        $fileDb->storage = $this->afterUploadData['storage'];
                    }

                    if ($fileDb->save()) {
                        echo Json::encode(['id' => $fileDb->id, 'filename' => $fileDb->name, 'url' => $this->afterUploadData['url']]);
                    } else {
                        echo Json::encode(['errors' => $fileDb->getErrors()]);
                    }
                }
            }
        }
    }
}
