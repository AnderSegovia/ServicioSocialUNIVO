<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_f1".
 *
 * @property int $id_f1
 * @property string $fecha_f1
 * @property string $direccion_f1
 * @property string|null $numero_pariente
 * @property string|null $nombre_pariente
 * @property int $fk_ocupacion
 * @property string|null $lugar_trabajo
 * @property string|null $horario_laboral
 * @property int $fk_distrito
 * @property int $fk_alumnof1
 *
 * @property TblAlumno $fkAlumnof1
 * @property TblDistritos $fkDistrito
 * @property TblOcupacion $fkOcupacion
 * @property TblPivotef1[] $tblPivotef1s
 */
class TblF1 extends \yii\db\ActiveRecord
{
    public $fk_municipio;
    public $fk_departamento;
    public $fk_dia;
    public $fk_turno;
    public $fk_estado_alumno;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_f1';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_f1'], 'safe'],
            [[ 'direccion_f1', 'fk_ocupacion', 'fk_distrito', 'fk_alumnof1'], 'required'],
            [[ 'fk_ocupacion', 'fk_distrito', 'fk_alumnof1', 'fk_dia', 'fk_turno'], 'integer'],
            [['direccion_f1'], 'string', 'max' => 255],
            [['numero_pariente'], 'string', 'max' => 10],
            [['nombre_pariente'], 'string', 'max' => 150],
            [['lugar_trabajo', 'horario_laboral'], 'string', 'max' => 200],
            [['fk_alumnof1'], 'exist', 'skipOnError' => true, 'targetClass' => TblAlumno::class, 'targetAttribute' => ['fk_alumnof1' => 'id_alumno']],
            [['fk_distrito'], 'exist', 'skipOnError' => true, 'targetClass' => TblDistritos::class, 'targetAttribute' => ['fk_distrito' => 'id_distrito']],
            [['fk_ocupacion'], 'exist', 'skipOnError' => true, 'targetClass' => TblOcupacion::class, 'targetAttribute' => ['fk_ocupacion' => 'id_ocupacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_f1' => 'Id F1',
            'fecha_f1' => 'Fecha',
            'cant_materias' => 'Materias Aprobadas',
            'direccion_f1' => 'Dirección de Residencia',
            'numero_pariente' => 'Numero Pariente (Opcional)',
            'nombre_pariente' => 'Nombre Pariente (Opcional)',
            'fk_ocupacion' => 'Ocupación',
            'lugar_trabajo' => 'Lugar Trabajo',
            'horario_laboral' => 'Horario Laboral',
            'fk_distrito' => 'Distrito',
            'fk_alumnof1' => 'Alumno',
            'fk_dia' => 'Día',
            'fk_turno' => 'Horario',
        ];
    }

    /**
     * Gets query for [[FkAlumnof1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkAlumnof1()
    {
        return $this->hasOne(TblAlumno::class, ['id_alumno' => 'fk_alumnof1']);
    }

    /**
     * Gets query for [[FkDistrito]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkDistrito()
    {
        return $this->hasOne(TblDistritos::class, ['id_distrito' => 'fk_distrito']);
    }

    /**
     * Gets query for [[FkOcupacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkOcupacion()
    {
        return $this->hasOne(TblOcupacion::class, ['id_ocupacion' => 'fk_ocupacion']);
    }

    /**
     * Gets query for [[TblPivotef1s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTblPivotef1s()
    {
        return $this->hasMany(TblPivotef1::class, ['fk_f1' => 'id_f1']);
    }
    public function getFkMunicipio()
{
    return $this->hasOne(TblMunicipios::className(), ['id_municipio' => 'fk_municipio']);
}
public function getFkDepartamento()
{
    return $this->hasOne(TblDepartamentos::className(), ['id_departamento' => 'fk_departamento']);
}
public function getDiasDisponibles()
{
    return TblDias::find()->all();
}
public function getTurnosDisponibles()
{
    return TblTurnos::find()->all();
}
}
