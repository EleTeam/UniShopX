<?php
/**
 * ETShop-for-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-08-02
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'status', 'updated_at', 'updated_by', 'area_id', 'area_parent_id', 'cart_id', 'cookie_id', 'ip', 'preorder_id', 'user_id', 'total_count', 'print_count'], 'integer'],
            [['address_detail', 'address_fullname', 'address_telephone', 'area_name', 'area_path_ids', 'area_path_names', 'area_simple_name', 'area_zip_code', 'serial_no', 'coupon_user_id', 'address_id', 'has_paid', 'pay_type', 'notice', 'rough_pay_type', 'status_id', 'op_transaction_id', 'status_union', 'min_total_price_label', 'paid_date', 'store_id'], 'safe'],
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
        $query = Order::find();

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
            'area_id' => $this->area_id,
            'area_parent_id' => $this->area_parent_id,
            'cart_id' => $this->cart_id,
            'cookie_id' => $this->cookie_id,
            'ip' => $this->ip,
            'preorder_id' => $this->preorder_id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'total_count' => $this->total_count,
            'print_count' => $this->print_count,
            'coupon_user_total_price' => $this->coupon_user_total_price,
            'origin_total_price' => $this->origin_total_price,
            'paid_date' => $this->paid_date,
        ]);

        $query->andFilterWhere(['like', 'address_detail', $this->address_detail])
            ->andFilterWhere(['like', 'address_fullname', $this->address_fullname])
            ->andFilterWhere(['like', 'address_telephone', $this->address_telephone])
            ->andFilterWhere(['like', 'area_name', $this->area_name])
            ->andFilterWhere(['like', 'area_path_ids', $this->area_path_ids])
            ->andFilterWhere(['like', 'area_path_names', $this->area_path_names])
            ->andFilterWhere(['like', 'area_simple_name', $this->area_simple_name])
            ->andFilterWhere(['like', 'area_zip_code', $this->area_zip_code])
            ->andFilterWhere(['like', 'serial_no', $this->serial_no])
            ->andFilterWhere(['like', 'coupon_user_id', $this->coupon_user_id])
            ->andFilterWhere(['like', 'address_id', $this->address_id])
            ->andFilterWhere(['like', 'has_paid', $this->has_paid])
            ->andFilterWhere(['like', 'pay_type', $this->pay_type])
            ->andFilterWhere(['like', 'notice', $this->notice])
            ->andFilterWhere(['like', 'rough_pay_type', $this->rough_pay_type])
            ->andFilterWhere(['like', 'status_id', $this->status_id])
            ->andFilterWhere(['like', 'op_transaction_id', $this->op_transaction_id])
            ->andFilterWhere(['like', 'status_union', $this->status_union])
            ->andFilterWhere(['like', 'min_total_price_label', $this->min_total_price_label])
            ->andFilterWhere(['like', 'store_id', $this->store_id]);

        return $dataProvider;
    }
}
