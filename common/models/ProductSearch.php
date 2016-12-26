<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-18
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'sort', 'created_at', 'created_by', 'updated_at', 'updated_by', 'featured_position_sort', 'app_featured_home_sort', 'app_featured_topic_sort', 'status'], 'integer'],
            [['image', 'featured_image', 'image_small', 'name', 'featured_position', 'app_featured_home', 'app_featured_image', 'short_description', 'meta_keywords', 'meta_description', 'is_audit', 'remarks', 'featured', 'description', 'image_medium', 'image_large', 'app_featured_topic', 'app_long_image1', 'app_long_image2', 'app_long_image3', 'type', 'app_long_image4', 'app_long_image5'], 'safe'],
            [['price', 'featured_price'], 'number'],
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
        $query = Product::find();

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
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'price' => $this->price,
            'featured_price' => $this->featured_price,
            'featured_position_sort' => $this->featured_position_sort,
            'app_featured_home_sort' => $this->app_featured_home_sort,
            'app_featured_topic_sort' => $this->app_featured_topic_sort,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'featured_image', $this->featured_image])
            ->andFilterWhere(['like', 'image_small', $this->image_small])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'featured_position', $this->featured_position])
            ->andFilterWhere(['like', 'app_featured_home', $this->app_featured_home])
            ->andFilterWhere(['like', 'app_featured_image', $this->app_featured_image])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'is_audit', $this->is_audit])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'featured', $this->featured])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image_medium', $this->image_medium])
            ->andFilterWhere(['like', 'image_large', $this->image_large])
            ->andFilterWhere(['like', 'app_featured_topic', $this->app_featured_topic])
            ->andFilterWhere(['like', 'app_long_image1', $this->app_long_image1])
            ->andFilterWhere(['like', 'app_long_image2', $this->app_long_image2])
            ->andFilterWhere(['like', 'app_long_image3', $this->app_long_image3])
            ->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'app_long_image4', $this->app_long_image4])
            ->andFilterWhere(['like', 'app_long_image5', $this->app_long_image5]);

        return $dataProvider;
    }
}
