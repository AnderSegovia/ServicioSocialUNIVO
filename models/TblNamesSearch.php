<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblNames;

/**
 * TblNamesSearch represents the model behind the search form of `app\models\TblNames`.
 */
class TblNamesSearch extends TblNames
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_names'], 'integer'],
            [['baseform', 'accentsnames', 'create_at'], 'safe'],
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
        $query = TblNames::find();

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
            'id_names' => $this->id_names,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'baseform', $this->baseform])
            ->andFilterWhere(['like', 'accentsnames', $this->accentsnames]);

        return $dataProvider;
    }
}
