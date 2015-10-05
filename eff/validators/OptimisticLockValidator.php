<?php

namespace eff\validators;

use Yii;
use \yii\validators\Validator;

class OptimisticLockValidator extends Validator
{
    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->message = Yii::t('eff', 'Data is already expired');
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute < $model->getOldAttribute($attribute)) {
            $this->addError($model, $attribute, $this->message);
        }
    }
}