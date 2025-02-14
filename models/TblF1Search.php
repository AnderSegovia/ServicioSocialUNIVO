<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblF1;

/**
 * TblF1Search represents the model behind the search form of `app\models\TblF1`.
 */
class TblF1Search extends TblF1
{
    public $fk_carrera;
    public $fk_estado_alumno;
    public $nombre_alumno;
    public $codigo;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_f1',  'fk_ocupacion', 'fk_distrito', 'fk_alumnof1' ,'fk_carrera','fk_estado_alumno'], 'integer'],
            [['fecha_f1', 'direccion_f1', 'numero_pariente', 'nombre_pariente', 'lugar_trabajo', 'horario_laboral','nombre_alumno','codigo'], 'safe'],
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
        $query = TblF1::find();
        $query->joinWith(['fkAlumnof1']);
        $query->joinWith(['fkAlumnof1 fkAlumnof1', 'fkAlumnof1.fkCarrera fkCarrera']);
        $query->joinWith(['fkAlumnof1 fkAlumnof1', 'fkAlumnof1.fkEstadoAlumno fkEstadoAlumno']);
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_f1' => $this->id_f1,
            'fecha_f1' => $this->fecha_f1,
            'fk_ocupacion' => $this->fk_ocupacion,
            'fk_distrito' => $this->fk_distrito,
            'fk_alumnof1' => $this->fk_alumnof1,
        ]);

        $query->andFilterWhere(['like', 'direccion_f1', $this->direccion_f1])
            ->andFilterWhere(['like', 'numero_pariente', $this->numero_pariente])
            ->andFilterWhere(['like', 'nombre_pariente', $this->nombre_pariente])
            ->andFilterWhere(['like', 'lugar_trabajo', $this->lugar_trabajo])
            ->andFilterWhere(['like', 'horario_laboral', $this->horario_laboral]);

            $query->andFilterWhere(['like', 'tbl_alumno.nombre_alumno', $this->nombre_alumno])
            ->andFilterWhere(['like', 'tbl_alumno.codigo', $this->codigo]);
            
            $query->andFilterWhere(['fkCarrera.id_carrera' => $this->fk_carrera]);
            $query->andFilterWhere(['fkEstadoAlumno.id_estado_alumno' => $this->fk_estado_alumno]);



        return $dataProvider;
    }
}
