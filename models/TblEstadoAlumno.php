<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_estado_alumno".
 *
 * @property int $id_estado_alumno
 * @property string $estado_alumno
 *
 * @property TblAlumno[] $tblAlumnos
 */
class TblEstadoAlumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_estado_alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado_alumno'], 'required'],
            [['estado_alumno'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estado_alumno' => 'Id Estado Alumno',
            'estado_alumno' => 'Estado Alumno',
        ];
    }

    /**
     * Gets query for [[TblAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblAlumnos()
    {
        return $this->hasMany(TblAlumno::class, ['fk_estado_alumno' => 'id_estado_alumno']);
    }
}
