<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 9/29/15
 * Time: 11:44 AM
 */

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Manager extends Component
{
    private $_modules = [];
    private $_activeModules = [];
    private $_moduleTypes = [];

    /**
     * Get module information
     *
     * @return array
     */
    public function getModules()
    {
        // auto set module type value is an empty array if this was not set
        foreach($this->_moduleTypes as $moduleType) {
            if (!isset($this->_modules[$moduleType])) {
                $this->_modules[$moduleType] = [];
            }
        }

        // return current module values
        return $this->_modules;
    }

    /**
     * Register modules to manager
     *
     * @param $modules
     * @param $moduleType
     * @throws InvalidConfigException
     */
    public function registerModules($modules, $moduleType)
    {
        // assign module types
        if (!in_array($moduleType, $this->_moduleTypes)) {
            $this->_moduleTypes[] = $moduleType;
        }

        foreach($modules as $module) {
            self::registerModule($module, $moduleType);
        }
    }

    /**
     * Register module
     *
     * @param $module
     * @param $moduleType
     * @throws InvalidConfigException
     * @throws \yii\base\InvalidConfigException
     */
    protected function registerModule($module, $moduleType)
    {

        if (!isset($module['class']) || !isset($module['id'])) {
            throw new InvalidConfigException("Module id and class are required.");
        }

        // load as activated modules
        $isActivated = in_array($module['id'], self::getActiveModules(true)) ? true : false;

        // load module configuration
        $configuration = ['class' => $module['class']];
        if (!empty($module['configuration'])) {
            $configuration = ArrayHelper::merge($configuration, $module['configuration']);
        }

        // load as installed modules
        $objectModule = Yii::createObject($module['class'], [$module['id']]);

        // make sure that current module is extended from \common\components\Module class
        if (is_subclass_of($objectModule, Module::className())) {

            // set module basic information to optimize speed
            $objectModule->setModuleInfo($module);

            // register activated module
            if ($isActivated) {
                $objectModule->setActivated();
                Yii::$app->setModule($module['id'], $configuration);
            }
            $this->_modules[$moduleType][$module['id']] = $objectModule;
        }
    }

    /**
     * Get active modules
     *
     * @param bool $returnIds
     * @return array
     */
    protected function getActiveModules($returnIds = true)
    {
        if (!empty($this->_activeModules)) {
            return $this->_activeModules;
        }

        $activeModules = [];
        foreach(self::getDatabaseModules() as $module)
        {
            if ($module['status'] == Module::STATUS_ACTIVE) {
                $activeModules[] = $returnIds ? $module['unique_id'] : $module;
            }
        }
        $this->_activeModules = $activeModules;
        return $activeModules;
    }

    /**
     * Get active module from database
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function getDatabaseModules()
    {
        return \common\models\Module::find()->asArray()->all();
    }
}