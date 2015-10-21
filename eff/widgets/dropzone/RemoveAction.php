<?php

namespace eff\widgets\dropzone;

use Yii;
use yii\base\Action;

class RemoveAction extends Action
{
    public $uploadDir = '@files';

    public function run($fileName)
    {
        return (int)unlink(Yii::getAlias($this->uploadDir) . '/' . $fileName);
    }
}
