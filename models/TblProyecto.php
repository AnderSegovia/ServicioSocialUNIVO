<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_proyecto".
 *
 * @property int $id_proyecto
 * @property string $nombre_proyecto
 * @property string|null $numero_registro
 * @property string|null $horario
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property int|null $cant_beneficiados
 * @property float|null $cant_inversion
 * @property int $fk_carrera_proyecto
 * @property int $fk_estado_proyecto
 * @property int $fk_institucion
 * @property int $fk_impacto
 *
 * @property TblCarrera $fkCarreraProyecto
 * @property TblEstadoProyecto $fkEstadoProyecto
 * @property TblImpacto $fkImpacto
 * @property TblInstituciones $fkInstitucion
 * @property TblPivote[] $tblPivotes
 */
class TblProyecto extends \yii\db\ActiveRecord
{
    public $filtro_fk_carrera_proyecto;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_proyecto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_proyecto'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['cant_beneficiados', 'fk_carrera_proyecto', 'fk_estado_proyecto', 'fk_institucion', 'fk_impacto'], 'integer'],
            [['cant_inversion'], 'number'],
            [['nombre_proyecto'], 'string', 'max' => 255],
            [['numero_registro'], 'string', 'max' => 10],
            [['horario'], 'string', 'max' => 200],
            [['fk_carrera_proyecto'], 'exist', 'skipOnError' => true, 'targetClass' => TblCarrera::class, 'targetAttribute' => ['fk_carrera_proyecto' => 'id_carrera']],
            [['fk_estado_proyecto'], 'exist', 'skipOnError' => true, 'targetClass' => TblEstadoProyecto::class, 'targetAttribute' => ['fk_estado_proyecto' => 'id_estado_proyecto']],
            [['fk_impacto'], 'exist', 'skipOnError' => true, 'targetClass' => TblImpacto::class, 'targetAttribute' => ['fk_impacto' => 'id_impacto']],
            [['fk_institucion'], 'exist', 'skipOnError' => true, 'targetClass' => TblInstituciones::class, 'targetAttribute' => ['fk_institucion' => 'id_institucion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_proyecto' => 'Id Proyecto',
            'nombre_proyecto' => 'Nombre Proyecto',
            'numero_registro' => 'Registro',
            'horario' => 'Horario',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'cant_beneficiados' => 'Cantidad  de Beneficiados',
            'cant_inversion' => 'Cantidad de Inversion',
            'fk_carrera_proyecto' => 'Carrera',
            'fk_estado_proyecto' => 'Estado Proyecto',
            'fk_institucion' => 'Institucion',
            'fk_impacto' => 'Impacto',
        ];
    }

    /**
     * Gets query for [[FkCarreraProyecto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkCarreraProyecto()
    {
        return $this->hasOne(TblCarrera::class, ['id_carrera' => 'fk_carrera_proyecto']);
    }

    public function getFkFacultad()
{
    return $this->hasOne(TblFacultad::className(), ['id_facultad' => 'fk_facultad'])
                ->via('fkCarreraProyecto');
}
public function getFkActividad()
{
    return $this->hasOne(TblActividad::className(), ['id_actividad' => 'fk_actividad'])
                ->via('fkInstitucion');
}
    /**
     * Gets query for [[FkEstadoProyecto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkEstadoProyecto()
    {
        return $this->hasOne(TblEstadoProyecto::class, ['id_estado_proyecto' => 'fk_estado_proyecto']);
    }    

    /**
     * Gets query for [[FkImpacto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkImpacto()
    {
        return $this->hasOne(TblImpacto::class, ['id_impacto' => 'fk_impacto']);
    }

    /**
     * Gets query for [[FkInstitucion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkInstitucion()
    {
        return $this->hasOne(TblInstituciones::class, ['id_institucion' => 'fk_institucion']);
    }

    /**
     * Gets query for [[TblPivotes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPivotes()
    {
        return $this->hasMany(TblPivote::class, ['fk_proyecto' => 'id_proyecto']);
    }
    public function getAlumnos()
    {
        return $this->hasMany(TblAlumno::class, ['id_alumno' => 'fk_alumno'])
                    ->via('tblPivotes');
    }
}
