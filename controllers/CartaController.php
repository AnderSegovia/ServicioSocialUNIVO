<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use Mpdf\Mpdf;
use app\models\TblAlumno;
use app\models\TblArchivos;
use app\models\TblNames;
use app\models\TblExpediente;
use app\models\TblInstituciones;
use app\models\TblCargos;
use app\models\TblPivote;
use app\models\TblProyecto;
use app\models\UploadForm;
use DateTime;
use NumberFormatter;
use setasign\Fpdi\Fpdi;
use yii\web\Response;
use yii\web\UploadedFile;

class CartaController extends BaseController
{
    public function actionIndex()
    {
        $model = new TblAlumno();
        $instituciones = TblInstituciones::find()->all();

        return $this->render('index', [
            'model' => $model,  
            'instituciones' => $instituciones,
        ]);
    }
    public function actionGenerarCarta($idAlumnos, $idInstitucion, $campoNumerico)
    {
        $idAlumnos = explode(',', $idAlumnos);
        $alumnos = TblAlumno::find()->where(['id_alumno' => $idAlumnos])->all();
        $director = TblCargos::findOne(1);
        $coordinador = TblCargos::findOne(2);

    
        if (empty($alumnos)) {
            throw new \yii\web\NotFoundHttpException("No se encontraron alumnos con los IDs proporcionados.");
        }
    
        $institucion = TblInstituciones::findOne($idInstitucion);
        if ($institucion === null) {
            throw new \yii\web\NotFoundHttpException("La institución con ID $idInstitucion no existe.");
        }

        $nombreFormateado = $this->formatInstitutionName($institucion->nombre_institucion);
    
        $html = $this->renderPartial('carta', [
            'alumnos' => $alumnos,
            'institucion' => $institucion,
            'nombreFormateado' => $nombreFormateado,
            'campoNumerico' => $campoNumerico,
            'director' => $director,
            'coordinador' => $coordinador
        ]);
    
        $mpdf = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => 'Letter',
                'fontDir' => ['C:/xampp/htdocs/ServicioSocialUnivo/views/carta/fonts'],
                'fontdata' => [
                    'arial' => [
                        'R' => 'arial.ttf',
                        'B' => 'arialbd.ttf',
                        'I' => 'ariali.ttf',
                        'BI' => 'arialbi.ttf',
                    ]
                ],
                'default_font' => 'arial',
            
            'format' => 'Letter',
            'margin_left' => 30,
            'margin_right' => 20,
            'margin_top' => 20,
            'margin_bottom' => 5
        ]);
    
        $mpdf->WriteHTML("<style>p { text-align: justify; }</style>");
        $mpdf->WriteHTML($html);
    
        $uniqueFileName = 'Carta_' . date('Ymd_His') . '.pdf';
        $filePath = 'C:/xampp/htdocs/ServicioSocialUnivo/web/archivos/' . $uniqueFileName;
        
        $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

        $archivo = new TblArchivos();
        $archivo->nombre_archivo = $uniqueFileName;
        $archivo->fk_institucionArchivo= $idInstitucion;
        
        if ($archivo->save()) {
            $idArchivoGuardado = $archivo->id_archivo;
            
            foreach ($idAlumnos as $idAlumno) {
                // Actualizar el estado del alumno
                $alumno = TblAlumno::findOne($idAlumno);
                if ($alumno) {
                    $alumno->fk_estado_alumno = 1;
                    if (!$alumno->save()) {
                        Yii::error("Error al actualizar el estado del alumno ID $idAlumno: " . json_encode($alumno->errors));
                    }
                } else {
                    Yii::error("No se encontró el alumno con ID $idAlumno");
                }
                
                // Guardar el expediente
                $expediente = new TblExpediente();
                $expediente->fk_alumnoExpediente = $idAlumno;
                $expediente->fk_tipoExpediente = 1;
                $expediente->fk_archivo = $idArchivoGuardado;
                
                if (!$expediente->save()) {
                    Yii::error("Error al guardar el expediente para el alumno ID $idAlumno: " . json_encode($expediente->errors));
                }
            }
        } else {
            Yii::error("Error al guardar la carta");
        }
        

        return Yii::$app->response->sendFile($filePath, $uniqueFileName, ['inline' => true]);
    }
    private function formatInstitutionName($name) {
        $lowercaseWords = ['la', 'los', 'que', 'lo', 'de', 'del', 'al', 'y', 'a', 'el', 'las', 'en', 'con', 'por', 'para'];
        $exceptions = ['El Salvador','FUNDAGEO','La Unión','SOS','La Trinidad','USAID','El Niño','ADESCO','El Milagro','UNIVO','INN','El Rosario','Las Marias','El Zamorán','ES0867','FULSAMO','ES0841','La Sincuya','S.A','C.V']; // Lista de excepciones
        $exceptionPlaceholders = [];
    
        // Paso 1: Reemplazar excepciones con marcadores únicos
        foreach ($exceptions as $index => $exception) {
            if (stripos($name, $exception) !== false) {
                $placeholder = "__EXCEPTION_{$index}__";
                $exceptionPlaceholders[$placeholder] = $exception;
                $name = str_ireplace($exception, $placeholder, $name);
            }
        }
    
        // Paso 2: Extraer y preservar texto entre paréntesis
        preg_match_all('/\((.*?)\)/', $name, $matches);
        $parts = preg_split('/(\(.*?\))/', $name, -1, PREG_SPLIT_DELIM_CAPTURE);
    
        // Paso 3: Formatear las partes fuera de los paréntesis
        foreach ($parts as &$part) {
            if (preg_match('/^\(.*?\)$/', $part)) {
                continue; // Saltar partes que están entre paréntesis
            }
            
            $words = preg_split('/(\W+)/u', $part, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            foreach ($words as &$word) {
                if (array_key_exists($word, $exceptionPlaceholders)) {
                    $word = $exceptionPlaceholders[$word];
                } elseif (!in_array(mb_strtolower($word, 'UTF-8'), $lowercaseWords)) {
                    $word = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                } else {
                    $word = mb_strtolower($word, 'UTF-8');
                }
            }
            $part = implode('', $words);
        }
    
        // Paso 4: Unir las partes formateadas
        $formattedName = implode('', $parts);
    
        // Paso 5: Restaurar las excepciones
        foreach ($exceptionPlaceholders as $placeholder => $exception) {
            $formattedName = str_replace($placeholder, $exception, $formattedName);
        }
    
        return trim($formattedName);
    }
    public function actionSubir()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        $pdfFile = UploadedFile::getInstanceByName('pdfFile');
        $tipo = Yii::$app->request->post('tipo'); // Recibir el tipo (2 para plan, 3 para memoria)
        $idAlumnos = Yii::$app->request->post('idAlumnos');
        $idInstitucion = Yii::$app->request->post('idInstitucion');

    
        // Procesar el archivo PDF y los datos adicionales
        if ($pdfFile !== null && $tipo !== null && $idAlumnos !== null) {
            // Guardar el archivo en el servidor
            $rutaArchivo = 'C:/xampp/htdocs/ServicioSocialUnivo/web/archivos/';
            if($tipo==2){
                $nombreArchivo = 'Plan_'.uniqid() . '.' . $pdfFile->extension;

            }else if($tipo==3){
                $nombreArchivo = 'Memoria_'.uniqid() . '.' . $pdfFile->extension;
            }
    
            if ($pdfFile->saveAs($rutaArchivo . $nombreArchivo)) {
                // Guardar el nombre del archivo en la tabla archivos
                $archivo = new TblArchivos();
                $archivo->nombre_archivo = $nombreArchivo;
                $archivo->fk_institucionArchivo= $idInstitucion;

    
                if ($archivo->save()) {
                    $idArchivo = $archivo->id_archivo;
    
                    // Convertir idAlumnos a un array de IDs
                    $idAlumnosArray = explode(',', $idAlumnos);
    
                    // Guardar en la tabla expediente para cada ID de alumno
                    foreach ($idAlumnosArray as $idAlumno) {
                        $expediente = new TblExpediente();
                        $expediente->fk_alumnoExpediente = $idAlumno;
                        $expediente->fk_tipoExpediente = $tipo;
                        $expediente->fk_archivo = $idArchivo;
    
                        if (!$expediente->save()) {
                            Yii::error("Error al guardar el expediente para el alumno ID $idAlumno: " . json_encode($expediente->errors));
                        }
                    }
    
                    return ['status' => 'success', 'message' => 'Archivos subidos y registrados correctamente.'];
                } else {
                    Yii::error("Error al guardar el archivo en la base de datos");
                    return ['status' => 'error', 'message' => 'Error al guardar el archivo en la base de datos.'];
                }
            } else {
                Yii::error("Error al guardar el archivo en el servidor");
                return ['status' => 'error', 'message' => 'Error al guardar el archivo en el servidor.'];
            }
        } else {
            Yii::error("Datos incompletos recibidos");
            return ['status' => 'error', 'message' => 'Datos incompletos recibidos.'];
        }
    }
    public function actionVerPdf($nombre)
    {
        $path = Yii::getAlias('C:/xampp/htdocs/ServicioSocialUnivo/web/archivos/' . $nombre);
        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $nombre, ['inline' => true]);
        } else {
            throw new \yii\web\NotFoundHttpException('El archivo no existe.');
        }
    }
    // Función para convertir número a palabras
    private function numberToWords($number)
    {
        $f = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        return $f->format($number);
    }
    // Función para formatear la fecha en palabras
    private function formatDateToWords($date)
    {
        $dateTime = new DateTime($date);
        $day = ($dateTime->format('j') == 21) ? 'veintiun' : $this->numberToWords($dateTime->format('j'));
        $month = $dateTime->format('F');
        $year = $this->numberToWords($dateTime->format('Y'));
    
        $months = [
            'January' => 'enero',
            'February' => 'febrero',	
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre',
        ];
    
        return "a los $day días del mes de " . $months[$month] . " del año $year";
    }
    // Función para formatear fechas personalizadas
    private function formatCustomDate($date, $dateFormatter)
    {
        if ($date) {
            $day = $date->format('d');
            if ($day < 10) {
                $day = str_pad($day, 2, '0', STR_PAD_LEFT);
            }
            $formattedDate = $dateFormatter->format($date);
            return preg_replace('/\b\d{1,2}\b/', $day, $formattedDate, 1);
        }
        return null;
    }
    public function actionConstancia()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        try {
            if (Yii::$app->request->isPost) {
                $datosAdicionales = Yii::$app->request->post('datosAdicionales');
                $estudiantes = Yii::$app->request->post('estudiantes');
                $idInstitucion = Yii::$app->request->post('idInstitucion');
                $idInstitucion2 = Yii::$app->request->post('idInstitucion2');
                $actividades = Yii::$app->request->post('actividades');
                $actividades2 = Yii::$app->request->post('actividades2');
    
                if (empty($datosAdicionales) || empty($estudiantes) || empty($idInstitucion)) {
                    throw new \Exception('Faltan datos requeridos.');
                }
    
                // Ruta donde se guardarán los PDFs
                $pdfDir = Yii::getAlias('@webroot/archivos/');
                if (!is_dir($pdfDir)) {
                    mkdir($pdfDir, 0777, true);
                }
    
                $pdfFiles = [];
                $combinedPdfFilePath = $pdfDir . 'Constancia-Solvencia.pdf';

                $director = TblCargos::findOne(1);
                $coordinador = TblCargos::findOne(2);
                $colaborador = TblCargos::findOne(3);


                $institucion = TblInstituciones::findOne($idInstitucion);
                if (!$institucion) {
                    throw new \Exception('Institución no encontrada: ' . $idInstitucion);
                }
                $institucion2 = TblInstituciones::findOne($idInstitucion2);
                if (!$institucion2) {
                    throw new \Exception('Institución2 no encontrada: ' . $idInstitucion2);
                }
                $nombreFormateado = $this->formatInstitutionName($institucion->nombre_institucion);
                $nombreFormateado2 = $this->formatInstitutionName($institucion2->nombre_institucion);

                $dateFormatterFull = new \IntlDateFormatter(
                    'es_ES',
                    \IntlDateFormatter::FULL,
                    \IntlDateFormatter::NONE,
                    'America/El_Salvador',
                    \IntlDateFormatter::TRADITIONAL,
                    "d 'de' MMMM 'del año' yyyy"
                );

                $dateFormatterNoYear = new \IntlDateFormatter(
                    'es_ES',
                    \IntlDateFormatter::FULL,
                    \IntlDateFormatter::NONE,
                    'America/El_Salvador',
                    \IntlDateFormatter::TRADITIONAL,
                    "d 'de' MMMM"
                );
                

                $fromDate = isset($datosAdicionales['from_date']) ? new \DateTime($datosAdicionales['from_date']) : null;
                $toDate = isset($datosAdicionales['to_date']) ? new \DateTime($datosAdicionales['to_date']) : null;

                $useFullFormatForFromDate = !$fromDate || !$toDate || $fromDate->format('Y') !== $toDate->format('Y');
                $dateFormatterForFromDate = $useFullFormatForFromDate ? $dateFormatterFull : $dateFormatterNoYear;

                $formattedFromDate = $this->formatCustomDate($fromDate, $dateFormatterForFromDate);
                $formattedToDate = $this->formatCustomDate($toDate, $dateFormatterFull);

                $fromDate2 = isset($datosAdicionales['from_date2']) ? new \DateTime($datosAdicionales['from_date2']) : null;
                $toDate2 = isset($datosAdicionales['to_date2']) ? new \DateTime($datosAdicionales['to_date2']) : null;

                $useFullFormatForFromDate2 = !$fromDate2 || !$toDate2 || $fromDate2->format('Y') !== $toDate2->format('Y');
                $dateFormatterForFromDate2 = $useFullFormatForFromDate2 ? $dateFormatterFull : $dateFormatterNoYear;
                $formattedFromDate2 = $this->formatCustomDate($fromDate2, $dateFormatterForFromDate2);
                $formattedToDate2 = $this->formatCustomDate($toDate2, $dateFormatterFull);
                $fecha = $this->formatDateToWords(date('Y-m-d'));
                // Generar PDFs individuales
                foreach ($estudiantes as $estudiante) {
                    if (!isset($estudiante['id'], $estudiante['gender'])) {
                        throw new \Exception('Datos del estudiante incompletos.');
                    }
                    if (!isset($estudiante['id'], $estudiante['titulo'])) {
                        throw new \Exception('Datos del estudiante incompletos.');
                    }
    
                    $alumno = TblAlumno::findOne($estudiante['id']);
                    if (!$alumno) {
                        throw new \Exception('Estudiante no encontrado: ' . $estudiante['id']);
                    }                        
                // Variable para rastrear si hubo cambios
                $cambioRealizado = false;

                // Formatear el nombre del alumno y verificar si hubo cambios
                $nombreFormateadoEstudiante = $this->formatearNombre($alumno->nombre_alumno, $cambioRealizado);

                // Si hubo cambios, actualizar el nombre en la base de datos
                if ($cambioRealizado) {
                    $alumno->nombre_alumno = $nombreFormateadoEstudiante;
                    if (!$alumno->save()) {
                        throw new \Exception('Error al actualizar el nombre del alumno: ' . json_encode($alumno->errors));
                    }

                    // Mensaje de depuración
                    Yii::debug("Nombre del estudiante actualizado: " . $nombreFormateadoEstudiante);
                } else {
                    // Mensaje de depuración si no hubo cambios
                    Yii::debug("No se realizaron cambios en el nombre del estudiante: " . $alumno->nombre_alumno);
                }                    $data = [
                        'fecha' => $fecha,
                        'fromDate' => $formattedFromDate,
                        'toDate' => $formattedToDate,
                        'fromDate2' => $formattedFromDate2,
                        'toDate2' => $formattedToDate2,
                        'genero' => $estudiante['gender'],
                        'titulo' => $estudiante['titulo'],
                        'alumno' => $alumno,
                        'nombreFormateado' => $nombreFormateado,
                        'nombreFormateado2' => $nombreFormateado2,
                        'institucion' => $institucion,
                        'institucion2' => $institucion2,
                        'datosAdicionales' => $datosAdicionales,
                        'actividades' => $actividades,
                        'actividades2' => $actividades2,
                        'director' => $director,
                        'coordinador' => $coordinador,
                        'colaborador' => $colaborador,
                        'nombreFormateadoEstudiante' => $nombreFormateadoEstudiante
                    ];

                    
                    if($alumno->fkCarrera->fkFacultad->id_facultad == 2){
                        $constanciaSaludHtml = $this->renderPartial('constanciasalud', $data);
                    }else{
                        $constanciaHtml = $this->renderPartial('constancia', $data);
                    }
                    $juntaHtml = $this->renderPartial('junta', $data);
                    $solvenciaHtml = $this->renderPartial('solvencia', $data);
    
                    $mpdfConfig = [
                        'mode' => 'utf-8',
                        'format' => 'Letter',
                        'fontDir' => ['C:/xampp/htdocs/ServicioSocialUnivo/views/carta/fonts'],
                        'fontdata' => [
                            'arial' => [
                                'R' => 'arial.ttf',
                                'B' => 'arialbd.ttf',
                                'I' => 'ariali.ttf',
                                'BI' => 'arialbi.ttf',
                            ]
                        ],
                        'default_font' => 'arial'
                    ];
    
                    $mpdf = new \Mpdf\Mpdf($mpdfConfig);
                    if($alumno->fkCarrera->fkFacultad->id_facultad == 2){
                        $mpdf->WriteHTML($constanciaSaludHtml);
                        $mpdf->AddPage();
                        $mpdf->WriteHTML($constanciaSaludHtml);

                    }else{
                        $mpdf->WriteHTML($constanciaHtml);
                        $mpdf->AddPage();
                        $mpdf->WriteHTML($constanciaHtml);
                    }

                    if($alumno->fkCarrera->id_carrera == 33 || $alumno->fkCarrera->id_carrera == 56){
                        $mpdf->AddPage();
                        $mpdf->WriteHTML($juntaHtml);
                    }
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($solvenciaHtml);
    
                    $pdfFile = $alumno->codigo . '.pdf';
                    $pdfFilePath = $pdfDir . $pdfFile;
                    $mpdf->Output($pdfFilePath, 'F');
    
                    $pdfFiles[] = $pdfFilePath;


                        // Guardar el nombre del archivo en la tabla archivos
                        $archivo = new TblArchivos();
                        $archivo->nombre_archivo = $pdfFile;
                        $archivo->fk_institucionArchivo= $idInstitucion;
        
            
                        if ($archivo->save()) {
                            $idArchivo = $archivo->id_archivo;

                                $expediente = new TblExpediente();
                                $expediente->fk_alumnoExpediente = $alumno->id_alumno;
                                $expediente->fk_tipoExpediente = 4;
                                $expediente->fk_archivo = $idArchivo;
            
                                if (!$expediente->save()) {
                                    Yii::error("Error al guardar el expediente para el alumno ID $alumno->id_alumno: " . json_encode($expediente->errors));
                                }
                            }
                            $proyectoId = TblProyecto::findOne($datosAdicionales['proyectoId']);
                                if($proyectoId){
                                    $proyectoId->fk_estado_proyecto=4;
                                }
                    
                            $alumnoId = TblAlumno::findOne($alumno->id_alumno);
                            if ($alumnoId) {
                                $alumno->fk_estado_alumno = 4;
                                if (!$alumno->save()) {
                                    Yii::error("Error al actualizar el estado del alumno ID $alumno->id_alumno: " . json_encode($alumno->errors));
                                }
                            } else {
                                Yii::error("No se encontró el alumno con ID $alumno->id_alumno");
                            } 

                }
    
                // Combinar los PDFs individuales en uno solo usando FPDI
                $pdf = new Fpdi();
                foreach ($pdfFiles as $pdfFile) {
                    $pageCount = $pdf->setSourceFile($pdfFile);
                    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                        $templateId = $pdf->importPage($pageNo);
                        $size = $pdf->getTemplateSize($templateId);
                        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                        $pdf->useTemplate($templateId);
                    }
                }
    
                // Guardar el PDF combinado
                $pdf->Output($combinedPdfFilePath, 'F');
    
                if (!empty($pdfFiles)) {
                    return [
                        'success' => true,
                        'message' => 'PDFs generados y combinados exitosamente',
                        'combinedPdfUrl' => Yii::$app->request->baseUrl . '/archivos/Constancia-Solvencia.pdf',
                        'pdfFiles' => $pdfFiles,
                    ];
                } else {
                    throw new \Exception('No se pudieron generar los PDFs');
                }
            } else {
                throw new \Exception('Solicitud inválida');
            }
        } catch (\Exception $e) {
            Yii::error('Error en actionConstancia: ' . $e->getMessage() . "\n" . $e->getTraceAsString(), __METHOD__);
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage() . ' ' . $e->getTraceAsString(),
            ];
        }
    }
    public function actionProjectName($idAlumno)
    {
        $pivotes = TblPivote::find()->where(['fk_alumno' => $idAlumno])->all();
        if (count($pivotes) > 0) {
            $proyectoPrincipal = null;
            $proyectoSecundario = null;
            if (isset($pivotes[0])) {
                $proyectoPrincipal = TblProyecto::findOne($pivotes[0]->fk_proyecto);
                $alumno=TblAlumno::findOne($idAlumno);
                $carreraPs = $alumno->fkCarrera->id_carrera;
            }
            if (isset($pivotes[1])) {
                $proyectoSecundario = TblProyecto::findOne($pivotes[1]->fk_proyecto);
            }
           
    
            if ($proyectoPrincipal) {
                $institucionId = $proyectoPrincipal->fkInstitucion->id_institucion;
                $nombreFormateado = $this->formatInstitutionName($proyectoPrincipal->nombre_proyecto);
                
    
                $otrosAlumnos = TblPivote::find()
                    ->where(['fk_proyecto' => $pivotes[0]->fk_proyecto])
                    ->andWhere(['!=', 'fk_alumno', $idAlumno])
                    ->all();
    
                $alumnosIds = [];
                foreach ($otrosAlumnos as $otroAlumno) {
                    $alumnosIds[] = $otroAlumno->fk_alumno;
                }
                $proyectoId=$proyectoPrincipal->id_proyecto;
    
                $response = [
                    'success' => true,
                    'nombre_proyecto' => $nombreFormateado,
                    'institucion_id' => $institucionId,
                    'carreraPs' => $carreraPs,
                    'otros_alumnos' => $alumnosIds,
                    'proyectoId'=> $proyectoId
                ];
    
                if ($proyectoSecundario) {
                    $response['nombre_proyecto_secundario'] = $this->formatInstitutionName($proyectoSecundario->nombre_proyecto);
                    $response['institucion_id_secundaria'] = $proyectoSecundario->fkInstitucion->id_institucion;
                }
    
                return json_encode($response);
            }
        }
        return json_encode(['success' => false]);
    }
    public function formatearNombre($nombreCompleto, &$cambioRealizado = false) {
        // Obtener todas las correcciones de la base de datos
        $correcciones = TblNames::find()->all();
    
        // Dividir el nombre completo en partes individuales (nombres y apellidos)
        $partesNombre = explode(' ', $nombreCompleto);
    
        // Variable para rastrear si se realizó algún cambio
        $cambioRealizado = false;
    
        // Recorrer cada parte del nombre y aplicar correcciones
        foreach ($partesNombre as &$parte) {
            // Eliminar el punto al final del nombre (si existe)
            $parte = rtrim($parte, '.');
    
            // Guardar la parte original para comparar después
            $parteOriginal = $parte;
    
            // Comparar la parte del nombre con la versión sin tildes (baseform)
            foreach ($correcciones as $correccion) {
                if (mb_strtolower($parte) === mb_strtolower($correccion->baseform)) {
                    // Reemplazar con la versión con tildes (accentsnames)
                    $parte = $correccion->accentsnames;
                    // Si la parte cambió, marcar que hubo un cambio
                    if ($parte !== $parteOriginal) {
                        $cambioRealizado = true;
                    }
                    break; // Si encontramos una coincidencia, salimos del bucle
                }
            }
        }
    
        // Unir las partes corregidas para formar el nombre completo
        $nombreCorregido = implode(' ', $partesNombre);
    
        return $nombreCorregido;
    }
}
