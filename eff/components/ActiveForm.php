<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/2/15
 * Time: 2:26 PM
 */

namespace eff\components;


class ActiveForm extends \yii\widgets\ActiveForm
{
    public $enableClientValidation = false;
    public $errorSummaryCssClass = 'error-summary alert alert-danger';
}