<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblActividad;

/**
 * TblActividadSearch represents the model behind the search form of `app\models\TblActividad`.
 */
class TblActividadSearch extends TblActividad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_actividad', 'fk_lineamiento'], 'integer'],
            [['nombre_actividad'], 'safe'],
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
        $query = TblActividad::find();

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
            'id_actividad' => $this->id_actividad,
            'fk_lineamiento' => $this->fk_lineamiento,
        ]);

        $query->andFilterWhere(['like', 'nombre_actividad', $this->nombre_actividad]);

        return $dataProvider;
    }
}
