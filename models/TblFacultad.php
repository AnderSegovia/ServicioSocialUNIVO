<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_facultad".
 *
 * @property int $id_facultad
 * @property string $nombre_facultad
 *
 * @property TblCarrera[] $tblCarreras
 */
class TblFacultad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_facultad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_facultad'], 'required'],
            [['nombre_facultad'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_facultad' => 'Id Facultad',
            'nombre_facultad' => 'Nombre Facultad',
        ];
    }

    /**
     * Gets query for [[TblCarreras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblCarreras()
    {
        return $this->hasMany(TblCarrera::class, ['fk_facultad' => 'id_facultad']);
    }
}
