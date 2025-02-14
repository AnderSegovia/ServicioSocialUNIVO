<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_municipios".
 *
 * @property int $id_municipio
 * @property string $nombre_municipio
 * @property int $fk_departamento
 *
 * @property TblDepartamentos $fkDepartamento
 * @property TblDistritos[] $tblDistritos
 */
class TblMunicipios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_municipios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_municipio', 'fk_departamento'], 'required'],
            [['fk_departamento'], 'integer'],
            [['nombre_municipio'], 'string', 'max' => 200],
            [['fk_departamento'], 'exist', 'skipOnError' => true, 'targetClass' => TblDepartamentos::class, 'targetAttribute' => ['fk_departamento' => 'id_departamento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_municipio' => 'Id Municipio',
            'nombre_municipio' => 'Nombre Municipio',
            'fk_departamento' => 'Departamento',
        ];
    }

    /**
     * Gets query for [[FkDepartamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkDepartamento()
    {
        return $this->hasOne(TblDepartamentos::class, ['id_departamento' => 'fk_departamento']);
    }

    /**
     * Gets query for [[TblDistritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblDistritos()
    {
        return $this->hasMany(TblDistritos::class, ['fk_municipio' => 'id_municipio']);
    }
}
