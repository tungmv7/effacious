<?php

namespace eff\modules\post\controllers;

use eff\components\Controller;

/**
 * AdminController implements the CRUD actions for Post model.
 */
class AdminController extends Controller
{
    public $modelClass = 'eff\modules\post\models\Post';
    public $modelSearchClass = 'eff\modules\post\models\PostSearch';
}
