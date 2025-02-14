<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblExpediente;

/**
 * TblExpendienteSearch represents the model behind the search form of `app\models\TblExpediente`.
 */
class TblExpendienteSearch extends TblExpediente
{
    public $fk_institucionArchivo;
    public $fk_carrera;
    public $fk_facultad;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_expediente', 'fk_alumnoExpediente', 'fk_tipoExpediente', 'fk_archivo','fk_institucionArchivo','fk_carrera','fk_facultad'], 'integer'],
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
        $query = TblExpediente::find()->groupBy('fk_archivo')->orderBy(['id_expediente' => SORT_DESC]);
        
        $query->joinWith(['fkArchivo fkArchivo', 'fkArchivo.fkInstitucionArchivo fkInstitucionArchivo']);
        $query->joinWith(['fkAlumnoExpediente fkAlumnoExpediente', 'fkAlumnoExpediente.fkCarrera fkCarrera']);
        $query->joinWith(['fkAlumnoExpediente fkAlumnoExpediente', 'fkAlumnoExpediente.fkCarrera.fkFacultad fkFacultad']);


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
            'id_expediente' => $this->id_expediente,
            'fk_alumnoExpediente' => $this->fk_alumnoExpediente,
            'fk_tipoExpediente' => $this->fk_tipoExpediente,
            'fk_archivo' => $this->fk_archivo,
        ]);
        $query->andFilterWhere(['fkInstitucionArchivo.id_institucion' => $this->fk_institucionArchivo]);
        $query->andFilterWhere(['fkCarrera.id_carrera' => $this->fk_carrera]);
        $query->andFilterWhere(['fkFacultad.id_facultad' => $this->fk_facultad]);




        return $dataProvider;
    }
}
