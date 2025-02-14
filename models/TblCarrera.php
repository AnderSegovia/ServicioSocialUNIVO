<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_carrera".
 *
 * @property int $id_carrera
 * @property string $nombre_carrera
 * @property int $fk_facultad
 * @property int|null $total_materias
 * @property int|null $cant_horas
 *
 * @property TblFacultad $fkFacultad
 * @property TblAlumno[] $tblAlumnos
 * @property TblProyecto[] $tblProyectos
 */
class TblCarrera extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_carrera';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_carrera', 'fk_facultad'], 'required'],
            [['fk_facultad', 'total_materias', 'cant_horas'], 'integer'],
            [['nombre_carrera'], 'string', 'max' => 200],
            [['fk_facultad'], 'exist', 'skipOnError' => true, 'targetClass' => TblFacultad::class, 'targetAttribute' => ['fk_facultad' => 'id_facultad']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_carrera' => 'Id Carrera',
            'nombre_carrera' => 'Nombre Carrera',
            'fk_facultad' => 'Fk Facultad',
            'total_materias' => 'Total Materias',
            'cant_horas' => 'Cantidad de Horas',
        ];
    }

    /**
     * Gets query for [[FkFacultad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkFacultad()
    {
        return $this->hasOne(TblFacultad::class, ['id_facultad' => 'fk_facultad']);
    }

    /**
     * Gets query for [[TblAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblAlumnos()
    {
        return $this->hasMany(TblAlumno::class, ['fk_carrera' => 'id_carrera']);
    }

    /**
     * Gets query for [[TblProyectos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblProyectos()
    {
        return $this->hasMany(TblProyecto::class, ['fk_carrera_proyecto' => 'id_carrera']);
    }
}
