<?php

namespace eff\modules\file;

class Module extends \common\components\Module
{
    public $controllerNamespace = 'eff\modules\file\controllers';

    public $basePath = '@files';

    public $baseUrl = '@files';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
