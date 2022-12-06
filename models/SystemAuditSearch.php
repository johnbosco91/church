<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @inheritdoc
 */
/**
 * @inheritdoc
 */

class SystemAuditSearch extends SystemAudit
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['userId'], 'integer'],
            [['date', 'data_change'], 'safe'],
            [['action'], 'string', 'max' => 255],
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
        $query = SystemAudit::find();
        $query->OrderBy("auditId DESC");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'userId' => $this->userId,
        ]);

        $query->andFilterWhere(['like', 'data_change', $this->data_change])
            ->andFilterWhere(['like', 'action', $this->action]);
        return $dataProvider;
    }
}
