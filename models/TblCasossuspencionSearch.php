<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblCasossuspencion;

/**
 * TblCasossuspencionSearch represents the model behind the search form of `app\models\TblCasossuspencion`.
 */
class TblCasossuspencionSearch extends TblCasossuspencion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_casos', 'fk_casoAlumno'], 'integer'],
            [['caso_descripcion'], 'safe'],
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
        $query = TblCasossuspencion::find();

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
            'id_casos' => $this->id_casos,
            'fk_casoAlumno' => $this->fk_casoAlumno,
        ]);

        $query->andFilterWhere(['like', 'caso_descripcion', $this->caso_descripcion]);

        return $dataProvider;
    }
}
