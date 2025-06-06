<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblEstadoProyecto;

/**
 * TblEstadoProyectoSearch represents the model behind the search form of `app\models\TblEstadoProyecto`.
 */
class TblEstadoProyectoSearch extends TblEstadoProyecto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estado_proyecto'], 'integer'],
            [['estado_proyecto'], 'safe'],
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
        $query = TblEstadoProyecto::find();

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
            'id_estado_proyecto' => $this->id_estado_proyecto,
        ]);

        $query->andFilterWhere(['like', 'estado_proyecto', $this->estado_proyecto]);

        return $dataProvider;
    }
}
