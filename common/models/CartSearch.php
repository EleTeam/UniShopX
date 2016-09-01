<?php
/**
 * ETShop-PHP-Yii2
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
 * CartSearch represents the model behind the search form about `common\models\Cart`.
 */
class CartSearch extends Cart
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'user_id', 'cookie_id', 'ip', 'app_cart_cookie_id'], 'integer'],
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
        $query = Cart::find();

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
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'user_id' => $this->user_id,
            'cookie_id' => $this->cookie_id,
            'ip' => $this->ip,
            'app_cart_cookie_id' => $this->app_cart_cookie_id,
        ]);

        return $dataProvider;
    }
}
