<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblProyecto;

/**
 * TblProyectoSearch represents the model behind the search form of `app\models\TblProyecto`.
 */
class TblProyectoSearch extends TblProyecto
{
    public $fk_facultad;
    public $fk_actividad;
    public $fk_lineamiento;
    public $fecha_inicio_from;
    public $fecha_inicio_to;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [    
            [['fecha_inicio_from', 'fecha_inicio_to'], 'safe'],
            [['id_proyecto', 'cant_beneficiados', 'cant_inversion', 'fk_estado_proyecto', 'fk_institucion', 'fk_impacto', 'fk_carrera_proyecto','fk_facultad','fk_actividad','fk_lineamiento'], 'integer'],
            [['nombre_proyecto', 'numero_registro', 'horario', 'fecha_inicio', 'fecha_fin'], 'safe'],
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
    $query = TblProyecto::find();

    // Unir con tablas relacionadas si es necesario
    $query->joinWith(['fkCarreraProyecto fkCarreraProyecto', 'fkCarreraProyecto.fkFacultad fkFacultad']);
    $query->joinWith(['fkInstitucion fkInstitucion', 'fkInstitucion.fkActividad fkActividad']);
    $query->joinWith(['fkInstitucion fkInstitucion', 'fkInstitucion.fkActividad.fkLineamiento fkLineamiento']);

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
        return $dataProvider;
    }

    // Filtrado por rango de fechas
    if ($this->fecha_inicio_from && $this->fecha_inicio_to) {
        $query->andFilterWhere(['between', 'fecha_inicio', $this->fecha_inicio_from, $this->fecha_inicio_to]);
    } elseif ($this->fecha_inicio_from) {
        $query->andFilterWhere(['>=', 'fecha_inicio', $this->fecha_inicio_from]);
    } elseif ($this->fecha_inicio_to) {
        $query->andFilterWhere(['<=', 'fecha_inicio', $this->fecha_inicio_to]);
    }

    // Filtrado adicional
    $query->andFilterWhere([
        'id_proyecto' => $this->id_proyecto,
        'fecha_inicio' => $this->fecha_inicio,
        'fecha_fin' => $this->fecha_fin,
        'cant_beneficiados' => $this->cant_beneficiados,
        'cant_inversion' => $this->cant_inversion,
        'fk_estado_proyecto' => $this->fk_estado_proyecto,
        'fk_institucion' => $this->fk_institucion,
        'fk_impacto' => $this->fk_impacto,
        'fk_carrera_proyecto' => $this->fk_carrera_proyecto,
    ]);

    $query->andFilterWhere(['like', 'nombre_proyecto', $this->nombre_proyecto])
          ->andFilterWhere(['like', 'numero_registro', $this->numero_registro])
          ->andFilterWhere(['like', 'horario', $this->horario]);

    $query->andFilterWhere(['fkFacultad.id_facultad' => $this->fk_facultad]);
    $query->andFilterWhere(['fkActividad.id_actividad' => $this->fk_actividad]);
    $query->andFilterWhere(['fkLineamiento.id_lineamiento' => $this->fk_lineamiento]);

    // Ordenar por la parte numérica de numero_registro
    $query->orderBy([
        'CAST(SUBSTRING_INDEX(numero_registro, "/", 1) AS UNSIGNED)' => SORT_ASC,
    ]);

    return $dataProvider;
}
}
