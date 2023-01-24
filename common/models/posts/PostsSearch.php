<?php

namespace common\models\posts;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\posts\Posts;

/**
 * PostsSearch represents the model behind the search form of `common\models\posts\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_category', 'status_post'], 'integer'],
            [['title_post', 'text_post'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Posts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        if (\Yii::$app->user->id == 1) {
            $query->andFilterWhere([
                'id' => $this->id,
                'id_user' => $this->id_user,
                'id_category' => $this->id_category,
                'status_post' => $this->status_post,
            ]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'id_user' => $this->id_user,
                'id_category' => $this->id_category,
                'status_post' => 0,
            ]);
        }

        $query->andFilterWhere(['like', 'title_post', $this->title_post])
            ->andFilterWhere(['like', 'text_post', $this->text_post]);

        return $dataProvider;
    }
}
