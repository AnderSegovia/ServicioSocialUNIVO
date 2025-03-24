<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_casossuspencion".
 *
 * @property int $id_casos
 * @property string $caso_descripcion
 * @property int $fk_casoAlumno
 *
 * @property TblAlumno $fkCasoAlumno
 */
class TblCasossuspencion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_casossuspencion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caso_descripcion', 'fk_casoAlumno'], 'required'],
            [['fk_casoAlumno'], 'integer'],
            [['caso_descripcion'], 'string', 'max' => 200],
            [['fk_casoAlumno'], 'exist', 'skipOnError' => true, 'targetClass' => TblAlumno::class, 'targetAttribute' => ['fk_casoAlumno' => 'id_alumno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_casos' => 'Id Casos',
            'caso_descripcion' => 'Justificación',
            'fk_casoAlumno' => 'Fk Caso Alumno',
        ];
    }

    /**
     * Gets query for [[FkCasoAlumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkCasoAlumno()
    {
        return $this->hasOne(TblAlumno::class, ['id_alumno' => 'fk_casoAlumno']);
    }
}
