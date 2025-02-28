<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\db\Expression;

class ExpedienteController extends Controller
{
    public function actionIndex()
    {
        $subQuery = (new Query())
            ->select(new Expression('1'))
            ->from(['t2' => 'tbl_expediente'])
            ->innerJoin(['a2' => 'tbl_archivos'], 't2.fk_archivo = a2.id_archivo')
            ->where('t2.fk_alumnoExpediente = t1.fk_alumnoExpediente')
            ->andWhere(['in', 't2.fk_tipoExpediente', [2, 3, 4]])
            ->andWhere('a2.fecha_creado > a.fecha_creado');

        // Consulta principal: se obtienen los expedientes de tipo 1, junto con la info del alumno y el cálculo de días transcurridos.
        $query = (new Query())
            ->select([
                't1.fk_alumnoExpediente',
                'al.nombre_alumno AS nombre_alumno',
                'al.codigo AS codigo',
                'a.fecha_creado',
                "DATEDIFF(CURDATE(), a.fecha_creado) AS dias_transcurridos"
            ])
            ->from(['t1' => 'tbl_expediente'])
            ->innerJoin(['a' => 'tbl_archivos'], 't1.fk_archivo = a.id_archivo')
            ->innerJoin(['al' => 'tbl_alumno'], 't1.fk_alumnoExpediente = al.id_alumno')
            ->where(['t1.fk_tipoExpediente' => 1])
            ->andWhere(['not exists', $subQuery])
            ->orderBy(['dias_transcurridos' => SORT_DESC]);

        $resultados = $query->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $resultados,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'attributes' => ['fk_alumnoExpediente', 'fecha_creado', 'dias_transcurridos'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
