<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/1/15
 * Time: 2:21 PM
 */

namespace common\components;

use Yii;
use yii\console\controllers\MigrateController;

class Migrate extends MigrateController
{
    public $migrationPath = '@console/migrations';

    public static function web($action, $migrationPath)
    {
        defined('STDOUT') or define('STDOUT', fopen('php://output', 'w'));
        defined('STDERR') or define('STDERR', fopen('php://output', 'w'));

        ob_start();
        $migrate = new self('migrate', Yii::$app);
        $migrate->migrationPath = $migrationPath;
        $migrate->interactive = false;
        $migrate->db = Yii::$app->db;
        $migrate->runAction($action);
        return ob_get_clean();
    }
}