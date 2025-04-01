<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblAlumno;

/**
 * TblAlumnoSearch represents the model behind the search form of `app\models\TblAlumno`.
 */
class TblAlumnoSearch extends TblAlumno
{
    public $fk_facultad;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alumno', 'fk_carrera','fk_facultad', 'fk_estado_alumno','numero_materias'], 'integer'],
            [['nombre_alumno', 'codigo', 'telefono', 'correo'], 'safe'],
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
        $query = TblAlumno::find();
        $query->joinWith(['fkCarrera fkCarrera', 'fkCarrera.fkFacultad fkFacultad']);


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
            'id_alumno' => $this->id_alumno,
            'fk_carrera' => $this->fk_carrera,
            'fk_estado_alumno' => $this->fk_estado_alumno,
        ]);
        $query->andFilterWhere(['fkFacultad.id_facultad' => $this->fk_facultad]);

        $query->andFilterWhere(['like', 'nombre_alumno', $this->nombre_alumno])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'numero_materias', $this->numero_materias]);
$query->orderBy(['id_alumno' => SORT_DESC]);

        return $dataProvider;
    }
}
