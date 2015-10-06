<?php
namespace eff\components;

use eff\behaviors\SoftDeleteBehavior;
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
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_deleted' => true
                ]
            ]
        ];
    }

    public static function find()
    {
        return parent::find()->where(['is_deleted' => false]);
    }
}