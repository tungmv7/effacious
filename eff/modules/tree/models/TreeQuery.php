<?php

namespace eff\modules\tree\models;
use eff\modules\tree\behaviors\TreeQueryBehavior;

/**
 * This is the ActiveQuery class for [[Tree]].
 *
 * @see Tree
 */
class TreeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function behaviors() {
        return [
            TreeQueryBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return Tree[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tree|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}