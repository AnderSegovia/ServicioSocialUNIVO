<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_cargos".
 *
 * @property int $id_cargos
 * @property string $cargo
 * @property string $nombre
 */
class TblCargos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_cargos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cargo', 'nombre'], 'required'],
            [['cargo', 'nombre'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cargos' => 'Id Cargos',
            'cargo' => 'Cargo',
            'nombre' => 'Nombre',
        ];
    }
}
