<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_archivos".
 *
 * @property int $id_archivo
 * @property string $nombre_archivo
 * @property int $fk_institucionArchivo
 * @property string $fecha_creado
 *
 * @property TblInstituciones $fkInstitucionArchivo
 * @property TblExpediente[] $tblExpedientes
 */
class TblArchivos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_archivos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_archivo'], 'required'],
            [['fk_institucionArchivo'], 'integer'],
            [['fecha_creado'], 'safe'],
            [['nombre_archivo'], 'string', 'max' => 200],
            [['fk_institucionArchivo'], 'exist', 'skipOnError' => true, 'targetClass' => TblInstituciones::class, 'targetAttribute' => ['fk_institucionArchivo' => 'id_institucion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_archivo' => 'Id Archivo',
            'nombre_archivo' => 'Nombre Archivo',
            'fk_institucionArchivo' => ' Institucion Archivo',
            'fecha_creado' => 'Fecha Creado',
        ];
    }

    /**
     * Gets query for [[FkInstitucionArchivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkInstitucionArchivo()
    {
        return $this->hasOne(TblInstituciones::class, ['id_institucion' => 'fk_institucionArchivo']);
    }

    /**
     * Gets query for [[TblExpedientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblExpedientes()
    {
        return $this->hasMany(TblExpediente::class, ['fk_archivo' => 'id_archivo']);
    }
}
