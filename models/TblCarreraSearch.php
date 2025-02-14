<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblCarrera;

/**
 * TblCarreraSearch represents the model behind the search form of `app\models\TblCarrera`.
 */
class TblCarreraSearch extends TblCarrera
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_carrera', 'fk_facultad', 'total_materias', 'cant_horas'], 'integer'],
            [['nombre_carrera'], 'safe'],
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
        $query = TblCarrera::find();

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
            'id_carrera' => $this->id_carrera,
            'fk_facultad' => $this->fk_facultad,
            'total_materias' => $this->total_materias,
            'cant_horas' => $this->cant_horas,
        ]);

        $query->andFilterWhere(['like', 'nombre_carrera', $this->nombre_carrera]);

        return $dataProvider;
    }
}
