<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_pivote".
 *
 * @property int $id_pivote
 * @property int $fk_alumno
 * @property int $fk_proyecto
 * @property int $fecha_creacion
 *
 * @property TblAlumno $fkAlumno
 * @property TblProyecto $fkProyecto
 */
class TblPivote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pivote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_alumno', 'fk_proyecto'], 'required'],
            [['fk_alumno', 'fk_proyecto'], 'integer'],
            [['fk_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => TblAlumno::class, 'targetAttribute' => ['fk_alumno' => 'id_alumno']],
            [['fk_proyecto'], 'exist', 'skipOnError' => true, 'targetClass' => TblProyecto::class, 'targetAttribute' => ['fk_proyecto' => 'id_proyecto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pivote' => 'Id Pivote',
            'fk_alumno' => 'Fk Alumno',
            'fk_proyecto' => 'Fk Proyecto',
            'fecha_creacion' => 'Fecha Creacion',
        ];
    }

    /**
     * Gets query for [[FkAlumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkAlumno()
    {
        return $this->hasOne(TblAlumno::class, ['id_alumno' => 'fk_alumno']);
    }

    /**
     * Gets query for [[FkProyecto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkProyecto()
    {
        return $this->hasOne(TblProyecto::class, ['id_proyecto' => 'fk_proyecto']);
    }
}
