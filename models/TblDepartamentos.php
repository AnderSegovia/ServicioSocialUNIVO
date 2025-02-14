<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_departamentos".
 *
 * @property int $id_departamento
 * @property string $nombre_departamento
 *
 * @property TblMunicipios[] $tblMunicipios
 */
class TblDepartamentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_departamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_departamento'], 'required'],
            [['nombre_departamento'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_departamento' => 'Id Departamento',
            'nombre_departamento' => 'Nombre Departamento',
        ];
    }

    /**
     * Gets query for [[TblMunicipios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblMunicipios()
    {
        return $this->hasMany(TblMunicipios::class, ['fk_departamento' => 'id_departamento']);
    }
}
