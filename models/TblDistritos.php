<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_distritos".
 *
 * @property int $id_distrito
 * @property string $nombre_distrito
 * @property int $fk_municipio
 *
 * @property TblMunicipios $fkMunicipio
 * @property TblF1[] $tblF1s
 */
class TblDistritos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_distritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_distrito', 'fk_municipio'], 'required'],
            [['fk_municipio'], 'integer'],
            [['nombre_distrito'], 'string', 'max' => 200],
            [['fk_municipio'], 'exist', 'skipOnError' => true, 'targetClass' => TblMunicipios::class, 'targetAttribute' => ['fk_municipio' => 'id_municipio']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_distrito' => 'Id Distrito',
            'nombre_distrito' => 'Nombre Distrito',
            'fk_municipio' => 'Municipio',
        ];
    }

    /**
     * Gets query for [[FkMunicipio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkMunicipio()
    {
        return $this->hasOne(TblMunicipios::class, ['id_municipio' => 'fk_municipio']);
    }

    /**
     * Gets query for [[TblF1s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblF1s()
    {
        return $this->hasMany(TblF1::class, ['fk_distrito' => 'id_distrito']);
    }
}
