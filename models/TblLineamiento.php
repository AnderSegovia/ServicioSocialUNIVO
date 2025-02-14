<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_lineamiento".
 *
 * @property int $id_lineamiento
 * @property string $nombre_lineamiento
 *
 * @property TblActividad[] $tblActividads
 */
class TblLineamiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_lineamiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_lineamiento'], 'required'],
            [['nombre_lineamiento'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_lineamiento' => 'Id Lineamiento',
            'nombre_lineamiento' => 'Nombre Lineamiento',
        ];
    }

    /**
     * Gets query for [[TblActividads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblActividads()
    {
        return $this->hasMany(TblActividad::class, ['fk_lineamiento' => 'id_lineamiento']);
    }
}
