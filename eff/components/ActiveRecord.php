<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/2/15
 * Time: 12:01 PM
 */

namespace eff\components;

use yii\behaviors\AttributeBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{
    const STATUS_REMOVED = 'removed';

    public function rules()
    {
        return [
            ['version', \eff\validators\OptimisticLockValidator::className()]
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => 'version'
                ],
                'value' => 0
            ]
        ];
    }
}