<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'password', 'phone_number', 'first_name', 'middle_name', 'surname', 'sex', 'email'], 'safe'],
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
    public function search($model)
    {
        $query = User::find();
        $query->joinWith("authAssignments");
        $query->andFilterWhere([
            'id' => $model->id,
            'status' => $model->status,
            'item_name' => $model->user_role,
        ]);
        $query->andFilterWhere([
            'or',
            ['like', 'first_name', $model->first_name],
            ['like', 'middle_name', $model->middle_name],
            ['like', 'surname', $model->surname],
            ['like', 'email', $model->email],
        ]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}
