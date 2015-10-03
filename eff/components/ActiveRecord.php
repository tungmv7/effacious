<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/2/15
 * Time: 12:01 PM
 */

namespace eff\components;


class ActiveRecord extends \yii\db\ActiveRecord
{
    const STATUS_REMOVED = 'removed';
}