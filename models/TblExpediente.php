<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_expediente".
 *
 * @property int $id_expediente
 * @property int $fk_alumnoExpediente
 * @property int $fk_tipoExpediente
 * @property int $fk_archivo
 *
 * @property TblAlumno $fkAlumnoExpediente
 * @property TblArchivos $fkArchivo
 * @property TblTipoexpediente $fkTipoExpediente
 */
class TblExpediente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_expediente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_alumnoExpediente', 'fk_tipoExpediente', 'fk_archivo'], 'required'],
            [['fk_alumnoExpediente', 'fk_tipoExpediente', 'fk_archivo'], 'integer'],
            [['fk_alumnoExpediente'], 'exist', 'skipOnError' => true, 'targetClass' => TblAlumno::class, 'targetAttribute' => ['fk_alumnoExpediente' => 'id_alumno']],
            [['fk_archivo'], 'exist', 'skipOnError' => true, 'targetClass' => TblArchivos::class, 'targetAttribute' => ['fk_archivo' => 'id_archivo']],
            [['fk_tipoExpediente'], 'exist', 'skipOnError' => true, 'targetClass' => TblTipoexpediente::class, 'targetAttribute' => ['fk_tipoExpediente' => 'id_tipoExpediente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_expediente' => 'Id Expediente',
            'fk_alumnoExpediente' => 'Fk Alumno Expediente',
            'fk_tipoExpediente' => 'Fk Tipo Expediente',
            'fk_archivo' => 'Fk Archivo',
        ];
    }

    /**
     * Gets query for [[FkAlumnoExpediente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkAlumnoExpediente()
    {
        return $this->hasOne(TblAlumno::class, ['id_alumno' => 'fk_alumnoExpediente']);
    }

    /**
     * Gets query for [[FkArchivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkArchivo()
    {
        return $this->hasOne(TblArchivos::class, ['id_archivo' => 'fk_archivo']);
    }

    /**
     * Gets query for [[FkTipoExpediente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkTipoExpediente()
    {
        return $this->hasOne(TblTipoexpediente::class, ['id_tipoExpediente' => 'fk_tipoExpediente']);
    }
}
