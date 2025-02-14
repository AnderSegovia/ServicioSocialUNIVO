<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblInstituciones;

/**
 * TblInstitucionesSearch represents the model behind the search form of `app\models\TblInstituciones`.
 */
class TblInstitucionesSearch extends TblInstituciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_institucion', 'fk_actividad', 'fk_distritoInst'], 'integer'],
            [['nombre_institucion', 'nombre_encargado', 'titulo', 'cargo', 'saludo', 'telefono_encargado', 'correo_encargado'], 'safe'],
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
        $query = TblInstituciones::find();

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
            'id_institucion' => $this->id_institucion,
            'fk_actividad' => $this->fk_actividad,
            'fk_distritoInst' => $this->fk_distritoInst,
        ]);

        $query->andFilterWhere(['like', 'nombre_institucion', $this->nombre_institucion])
            ->andFilterWhere(['like', 'nombre_encargado', $this->nombre_encargado])
            ->andFilterWhere(['like', 'titulo', $this->titulo])
            ->andFilterWhere(['like', 'cargo', $this->cargo])
            ->andFilterWhere(['like', 'saludo', $this->saludo])
            ->andFilterWhere(['like', 'telefono_encargado', $this->telefono_encargado])
            ->andFilterWhere(['like', 'correo_encargado', $this->correo_encargado]);

        return $dataProvider;
    }
}
