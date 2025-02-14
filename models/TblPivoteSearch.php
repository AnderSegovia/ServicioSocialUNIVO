<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblPivote;

/**
 * TblPivoteSearch represents the model behind the search form of `app\models\TblPivote`.
 */
class TblPivoteSearch extends TblPivote
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pivote', 'fk_alumno', 'fk_proyecto'], 'integer'],
            [['fecha_creacion'], 'safe'],
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
        $query = TblPivote::find();

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
            'id_pivote' => $this->id_pivote,
            'fk_alumno' => $this->fk_alumno,
            'fk_proyecto' => $this->fk_proyecto,
            'fecha_creacion' => $this->fecha_creacion,
        ]);

        return $dataProvider;
    }
}
