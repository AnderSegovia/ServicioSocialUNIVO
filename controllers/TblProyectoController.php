<?php

namespace app\controllers;

use app\models\TblAlumno;
use app\models\TblAlumnoSearch;
use app\models\TblPivote;
use app\models\TblProyecto;
use app\models\TblProyectoSearch;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * TblProyectoController implements the CRUD actions for TblProyecto model.
 */
class TblProyectoController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TblProyecto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TblProyectoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TblProyecto model.
     * @param int $id_proyecto Id Proyecto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_proyecto)
    {
        // Consulta para obtener todos los estudiantes con la columna 'codigo'
        $estudiantes = \app\models\TblAlumno::find()
            ->select(['id_alumno', 'codigo', 'nombre_alumno']) 
            ->asArray()
            ->all();
    
        // Crear un array que combine 'codigo' y 'nombre_alumno'
        $estudiantesList = \yii\helpers\ArrayHelper::map($estudiantes, 'id_alumno', function($estudiante) {
            return $estudiante['codigo'] . ' - ' . $estudiante['nombre_alumno'];
        });
    
        return $this->render('view', [
            'model' => $this->findModel($id_proyecto),
            'estudiantesList' => $estudiantesList
        ]);
    }
    public function actionFiltrarEstudiantes($search = '')
{
    // Consulta para obtener todos los estudiantes con la columna 'codigo' y 'nombre_alumno'
    $query = \app\models\TblAlumno::find()
        ->select(['id_alumno', 'codigo', 'nombre_alumno']);

    if ($search) {
        $query->andFilterWhere(['like', 'codigo', $search])
              ->orFilterWhere(['like', 'nombre_alumno', $search]);
    }

    $estudiantes = $query->asArray()->all();

    // Crear un array que combine 'codigo' y 'nombre_alumno'
    $estudiantesList = \yii\helpers\ArrayHelper::map($estudiantes, 'id_alumno', function($estudiante) {
        return  $estudiante['codigo'] . ' - ' . $estudiante['nombre_alumno'];
    });

    // Retornar el resultado en formato JSON
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $estudiantesList;


}


    /**
     * Creates a new TblProyecto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TblProyecto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_proyecto' => $model->id_proyecto]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TblProyecto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_proyecto Id Proyecto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_proyecto)
    {
        $model = $this->findModel($id_proyecto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            // Verificar si el estado del proyecto es 4
            if ($model->fk_estado_proyecto == 4) {
                // Obtener los alumnos ligados al proyecto
                $pivotes = TblPivote::find()->where(['fk_proyecto' => $model->id_proyecto])->all();
                foreach ($pivotes as $pivote) {
                    $alumno = TblAlumno::findOne($pivote->fk_alumno);
                    if ($alumno) {
                        $alumno->fk_estado_alumno = 4;
                        if (!$alumno->save()) {
                            Yii::error("Error al actualizar el estado del alumno ID {$alumno->id_alumno}: " . json_encode($alumno->errors));
                        }
                    }
                }
            }

            return $this->redirect(['view', 'id_proyecto' => $model->id_proyecto]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TblProyecto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_proyecto Id Proyecto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_proyecto)
    {
        $this->findModel($id_proyecto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TblProyecto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_proyecto Id Proyecto
     * @return TblProyecto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_proyecto)
    {
        if (($model = TblProyecto::findOne(['id_proyecto' => $id_proyecto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionAgregarEstudiante($id_proyecto)
{
    if (Yii::$app->request->isPost) {
        $idAlumno = Yii::$app->request->post('id_alumno');
        
        if ($idAlumno) {
            // Verificar que el estudiante y el proyecto existen
            $alumno = \app\models\TblAlumno::findOne($idAlumno);
            $proyecto = \app\models\TblProyecto::findOne($id_proyecto);
            
            if ($alumno && $proyecto) {
                // Verificar si la relación ya existe
                $existe = \app\models\TblPivote::find()
                    ->where(['fk_proyecto' => $id_proyecto, 'fk_alumno' => $idAlumno])
                    ->exists();
                
                if (!$existe) {
                    // Crear una nueva relación
                    $pivote = new \app\models\TblPivote();
                    $pivote->fk_proyecto = $id_proyecto; // Asignar el ID directamente
                    $pivote->fk_alumno = $idAlumno; // Asignar el ID directamente
                    
                    if ($pivote->save()) {
                        Yii::$app->session->setFlash('success', 'Estudiante agregado al proyecto exitosamente.');
                    } else {
                        Yii::$app->session->setFlash('error', 'No se pudo agregar el estudiante al proyecto. ' . implode(", ", $pivote->getFirstErrors()));
                    }
                } else {
                    Yii::$app->session->setFlash('warning', 'El estudiante ya está asociado a este proyecto.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Estudiante o proyecto no encontrado.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'No se ha seleccionado ningún estudiante.');
        }
    }
    
    return $this->redirect(['view', 'id_proyecto' => $id_proyecto]);
}
public function actionDeletePivote($id_alumno, $id_proyecto)
{
    $model = \app\models\TblPivote::findOne(['fk_alumno' => $id_alumno, 'fk_proyecto' => $id_proyecto]);

    if ($model !== null) {
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Estudiante eliminado del proyecto exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo eliminar al estudiante del proyecto.');
        }
    } else {
        Yii::$app->session->setFlash('error', 'No se encontró la relación entre el estudiante y el proyecto.');
    }

    return $this->redirect(['view', 'id_proyecto' => $id_proyecto]);
}
public function actionReport()
{
    // Obtener los parámetros de filtro aplicados en la vista de proyectos
    $searchModel = new TblProyectoSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    // Deshabilitar la paginación para obtener todos los resultados
    $dataProvider->pagination = false;

    // Obtener todos los modelos de proyectos filtrados
    $proyectos = $dataProvider->getModels();

    // Crear el objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Reporte de Proyectos');

    // Agregar encabezados
    $headers = [
       '#','Linea','Actividad','Nombre Proyecto', 'Registro', 'Fecha Inicio', 'Fecha Fin',
        'Institución', 'Facultad', 'Carrera',  'Inversion', 'Beneficiados',  'Estado',
        'Estudiante', 'Código', 'Teléfono', 'Correo'
    ];

    $cont=1;
    foreach ($headers as $index => $header) {
        $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
    }

    $row = 2;
    foreach ($proyectos as $proyecto) {
        // Mantener la fila inicial para combinar las celdas después
        $initialRow = $row;

        // Rellenar las celdas del proyecto
        $sheet->setCellValue('A' . $row, $cont);
        $sheet->setCellValue('B' . $row, $proyecto->fkInstitucion && $proyecto->fkInstitucion->fkActividad->fkLineamiento ? $proyecto->fkInstitucion->fkActividad->fkLineamiento->nombre_lineamiento : 'No definido');
        $sheet->setCellValue('C' . $row, $proyecto->fkInstitucion && $proyecto->fkInstitucion->fkActividad ? $proyecto->fkInstitucion->fkActividad->descripcion : 'No definido');
        $sheet->setCellValue('D' . $row, $proyecto->nombre_proyecto);
        $sheet->setCellValue('E' . $row, $proyecto->numero_registro);
        $sheet->setCellValue('F' . $row, $proyecto->fecha_inicio);
        $sheet->setCellValue('G' . $row, $proyecto->fecha_fin);
        $sheet->setCellValue('H' . $row, $proyecto->fkInstitucion ? $proyecto->fkInstitucion->nombre_institucion : 'No definido');
        $sheet->setCellValue('I' . $row, $proyecto->fkCarreraProyecto && $proyecto->fkCarreraProyecto->fkFacultad ? $proyecto->fkCarreraProyecto->fkFacultad->nombre_facultad : 'No definido');
        $sheet->setCellValue('J' . $row, $proyecto->fkCarreraProyecto ? $proyecto->fkCarreraProyecto->nombre_carrera : 'No definido');
        $sheet->setCellValue('K' . $row, $proyecto->cant_inversion);
        $sheet->setCellValue('L' . $row, $proyecto->cant_beneficiados);
        $sheet->setCellValue('M' . $row, $proyecto->fkEstadoProyecto ? $proyecto->fkEstadoProyecto->estado_proyecto : 'No definido');


        // Llenar los datos de los estudiantes
        foreach ($proyecto->alumnos as $alumno) {
            $sheet->setCellValue('N' . $row, $alumno->nombre_alumno);
            $sheet->setCellValue('O' . $row, $alumno->codigo);
            $sheet->setCellValue('P' . $row, $alumno->telefono);
            $sheet->setCellValue('Q' . $row, $alumno->correo);
            $row++;
        }

        $cont++;
        // Verificar si el proyecto tiene estudiantes
        if ($row - 1 >= $initialRow) {
            // Combinar las celdas del proyecto solo si el rango es válido
            $sheet->mergeCells('A' . $initialRow . ':A' . ($row - 1));
            $sheet->mergeCells('B' . $initialRow . ':B' . ($row - 1));
            $sheet->mergeCells('C' . $initialRow . ':C' . ($row - 1));
            $sheet->mergeCells('D' . $initialRow . ':D' . ($row - 1));
            $sheet->mergeCells('E' . $initialRow . ':E' . ($row - 1));
            $sheet->mergeCells('F' . $initialRow . ':F' . ($row - 1));
            $sheet->mergeCells('G' . $initialRow . ':G' . ($row - 1));
            $sheet->mergeCells('H' . $initialRow . ':H' . ($row - 1));
            $sheet->mergeCells('I' . $initialRow . ':I' . ($row - 1));
            $sheet->mergeCells('J' . $initialRow . ':J' . ($row - 1));
            $sheet->mergeCells('K' . $initialRow . ':K' . ($row - 1));
            $sheet->mergeCells('L' . $initialRow . ':L' . ($row - 1));
            $sheet->mergeCells('M' . $initialRow . ':M' . ($row - 1));

        } else {
            // Si no hay estudiantes, simplemente pasa a la siguiente fila
            $row++;
        }

    }

    // Guardar el archivo Excel en el servidor
    $writer = new Xlsx($spreadsheet);
    $filePath = Yii::getAlias('@webroot') . '/reporte_proyectos.xlsx';

    try {
        $writer->save($filePath);
    } catch (\Exception $e) {
        Yii::error('Error al guardar el archivo: ' . $e->getMessage(), __METHOD__);
        throw new \yii\web\HttpException(500, 'No se pudo generar el reporte.');
    }

    // Enviar el archivo al navegador para su descarga
    return Yii::$app->response->sendFile($filePath);
}

}
