<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_tipoexpediente".
 *
 * @property int $id_tipoExpediente
 * @property string $nombre_tipoExpediente
 *
 * @property TblExpediente[] $tblExpedientes
 */
class TblTipoexpediente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tipoexpediente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_tipoExpediente'], 'required'],
            [['nombre_tipoExpediente'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipoExpediente' => 'Id Tipo Expediente',
            'nombre_tipoExpediente' => 'Nombre Tipo Expediente',
        ];
    }

    /**
     * Gets query for [[TblExpedientes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblExpedientes()
    {
        return $this->hasMany(TblExpediente::class, ['fk_tipoExpediente' => 'id_tipoExpediente']);
    }
}
