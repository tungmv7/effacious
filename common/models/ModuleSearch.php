<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Module;

/**
 * ModuleSearch represents the model behind the search form about `common\models\Module`.
 */
class ModuleSearch extends Module
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isCoreModule', 'createdBy', 'createdTime', 'updatedBy', 'updatedTime'], 'integer'],
            [['uniqueId', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Module::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'isCoreModule' => $this->isCoreModule,
            'createdBy' => $this->createdBy,
            'createdTime' => $this->createdTime,
            'updatedBy' => $this->updatedBy,
            'updatedTime' => $this->updatedTime,
        ]);

        $query->andFilterWhere(['like', 'uniqueId', $this->uniqueId])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
