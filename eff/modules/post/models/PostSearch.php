<?php

namespace eff\modules\post\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use eff\modules\post\models\Post;

/**
 * PostSearch represents the model behind the search form about `eff\modules\post\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'creator', 'published_at', 'featured_image', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name', 'title', 'description', 'body', 'status', 'slug', 'type', 'visibility', 'password', 'meta_data', 'note'], 'safe'],
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
        $query = Post::find();

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
            'creator' => $this->creator,
            'published_at' => $this->published_at,
            'featured_image' => $this->featured_image,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'visibility', $this->visibility])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'meta_data', $this->meta_data])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
