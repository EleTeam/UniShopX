<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PreorderSearch represents the model behind the search form about `common\models\Preorder`.
 */
class PreorderSearch extends Preorder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'ip', 'user_id', 'cart_id', 'total_count', 'is_ordered', 'coupon_user_id', 'area_id', 'area_parent_id', 'address_id', 'pay_type', 'product_type', 'rough_pay_type', 'store_id'], 'integer'],
            [['cookie_id', 'area_name', 'area_path_ids', 'area_path_names', 'area_simple_name', 'area_zip_code', 'address_fullname', 'address_telephone', 'address_detail', 'min_total_price_label'], 'safe'],
            [['total_price', 'coupon_user_total_price', 'origin_total_price'], 'number'],
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
        $query = Preorder::find();

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
            'ip' => $this->ip,
            'user_id' => $this->user_id,
            'cart_id' => $this->cart_id,
            'total_count' => $this->total_count,
            'total_price' => $this->total_price,
            'is_ordered' => $this->is_ordered,
            'coupon_user_id' => $this->coupon_user_id,
            'coupon_user_total_price' => $this->coupon_user_total_price,
            'origin_total_price' => $this->origin_total_price,
            'area_id' => $this->area_id,
            'area_parent_id' => $this->area_parent_id,
            'address_id' => $this->address_id,
            'pay_type' => $this->pay_type,
            'product_type' => $this->product_type,
            'rough_pay_type' => $this->rough_pay_type,
            'store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'cookie_id', $this->cookie_id])
            ->andFilterWhere(['like', 'area_name', $this->area_name])
            ->andFilterWhere(['like', 'area_path_ids', $this->area_path_ids])
            ->andFilterWhere(['like', 'area_path_names', $this->area_path_names])
            ->andFilterWhere(['like', 'area_simple_name', $this->area_simple_name])
            ->andFilterWhere(['like', 'area_zip_code', $this->area_zip_code])
            ->andFilterWhere(['like', 'address_fullname', $this->address_fullname])
            ->andFilterWhere(['like', 'address_telephone', $this->address_telephone])
            ->andFilterWhere(['like', 'address_detail', $this->address_detail])
            ->andFilterWhere(['like', 'min_total_price_label', $this->min_total_price_label]);

        return $dataProvider;
    }
}
