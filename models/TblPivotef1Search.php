<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblPivotef1;

/**
 * TblPivotef1Search represents the model behind the search form of `app\models\TblPivotef1`.
 */
class TblPivotef1Search extends TblPivotef1
{
    public $fk_carrera;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pivotef1', 'fk_f1', 'fk_dia', 'fk_turno','fk_carrera'], 'integer'],
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
        $query = TblPivotef1::find();

        $query->joinWith(['fkAlumnof1 fkAlumnof1', 'fkAlumnof1.fkCarrera fkCarrera']);

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
            'id_pivotef1' => $this->id_pivotef1,
            'fk_f1' => $this->fk_f1,
            'fk_dia' => $this->fk_dia,
            'fk_turno' => $this->fk_turno,
        ]);
        $query->andFilterWhere(['fkCarrera.id_carrera' => $this->fk_carrera]);

        return $dataProvider;
    }
}
