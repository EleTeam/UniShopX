<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CmsArticle;

/**
 * CmsArticleSearch represents the model behind the search form about `common\models\CmsArticle`.
 */
class CmsArticleSearch extends CmsArticle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'weight', 'hits', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status'], 'integer'],
            [['title', 'link', 'color', 'image', 'keywords', 'description', 'weight_date', 'posid', 'custom_content_view', 'view_config', 'remarks'], 'safe'],
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
        $query = CmsArticle::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'weight' => $this->weight,
            'weight_date' => $this->weight_date,
            'hits' => $this->hits,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'posid', $this->posid])
            ->andFilterWhere(['like', 'custom_content_view', $this->custom_content_view])
            ->andFilterWhere(['like', 'view_config', $this->view_config])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
