<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/2/15
 * Time: 12:01 PM
 */

namespace eff\components;

use eff\behaviors\SoftDeleteBehavior;
use yii\behaviors\AttributeBehavior;
use \eff\validators\OptimisticLockValidator;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['version', OptimisticLockValidator::className()]
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
            ],
            [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => true
                ]
            ]
        ];
    }
}