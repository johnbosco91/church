<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LogsSearch extends Logs
{

    public function rules()
    {
        return [
            [['level', 'category', 'message'], 'string'],
            [['log_time'], 'safe'],
            [['user_email'], 'string', 'max' => 255],
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
    public function search($params, $condition="1=1")
    {
        $query = Logs::find();
        $query->andWhere($condition)->OrderBy("id DESC");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_email' => $this->user_email,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'level', $this->level]);
        return $dataProvider;
    }
}