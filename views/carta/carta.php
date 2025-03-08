<?php
/* @var $alumnos array */
/* @var $institucion app\models\TblInstituciones */
/* @var $nombreFormateado string */
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .header {
            text-align: center;
            font-family: Arial;
            position: relative;
            box-sizing: border-box;
        }
        .content {
            margin: 20px;
            font-size: 13px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 845px;
            height: 75px;
            overflow: hidden;
            justify-content: center;
        }
        .footer img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .table th, .table td {
            border: 0.8px solid black;
            padding: 2px;
            text-align: center;
            font-size: 10px;
        }
        .membrana {
            max-width: 30%;
            height: auto;
        }
        p {
            text-align: justify;
        }
        .center-text {
            display: flex;
            justify-content: center;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="/img/image.png" alt="Membrana" class="membrana">
    </div>

    <div class="content">
        <div style="display: flex; justify-content: space-between;">
            <div style="text-align: right;">
                <?php
                // Obtener la fecha actual
                $fecha = date('Y-m-d');

                // Obtener componentes de la fecha
                list($anio, $mes, $dia) = explode('-', $fecha);

                // Array de meses en español
                $meses = [
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                    7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ];

                // Imprimir la fecha en el formato deseado
                echo $meses[(int)$mes] . " $dia" . ", $anio";
                ?>
            </div>
            <div style="flex-grow: 1;">
                <?= $institucion->titulo ?><br>
                <b><?= $institucion->nombre_encargado ?><br></b>
                <?= $institucion->cargo ?><br>
                <b><?= htmlspecialchars($nombreFormateado, ENT_QUOTES, 'UTF-8') ?></b><br>
            </div>
        </div>

        <p><?= $institucion->saludo ?></p>

        <p>
            Por medio de la presente remito a usted, estudiante/s de la carrera <?= $alumnos[0]->fkCarrera->nombre_carrera ?>,
            de la <?= $alumnos[0]->fkCarrera->fkFacultad->nombre_facultad ?> de la Universidad de Oriente (UNIVO), para que realice
            Servicio Social Estudiantil con una duración de <?=$campoNumerico?>
            <?php if (count($alumnos) > 1): ?>
            horas cada uno,
     <?php else: ?>
        horas,
   <?php endif; ?> en la Institución que usted dirige.
        </p>

        <table class="table">
            <tr>
                <th class="table-title" colspan="4">TABLA 1. DATOS DE ESTUDIANTE/S</th>
            </tr>
            <tr>
                <th>N°</th>
                <th>NOMBRE</th>
                <th>CÓDIGO</th>
                <th>AVANCE ACADÉMICO</th>
            </tr>
            <?php foreach ($alumnos as $index => $alumno): ?>
                <?php
                $materias = ($alumno->numero_materias / $alumno->fkCarrera->total_materias) * 100;
                $materias = round($materias, 2);
                ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td style="text-align: left;"><?= $alumno->nombre_alumno ?></td>
                    <td><?= $alumno->codigo ?></td>
                    <td><?= $materias ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <p>
        <?php if (count($alumnos) > 1): ?>
            Los estudiantes cuentan
     <?php else: ?>
        El estudiante cuenta
   <?php endif; ?>
             con ocho días calendario, a partir de esta fecha para elaborar el Plan de Trabajo del Servicio Social, y presentarlo en la Coordinación de Servicio Social de la Universidad, para la aprobación, del cual se le enviará a usted una copia, por lo que solicito se le brinde 
             <?php if (count($alumnos) > 1): ?>
                a los estudiantes 
     <?php else: ?>
        al estudiante 
   <?php endif; ?>
              la información que requiera de manera oportuna. Sin aprobación del Plan de Trabajo, no se podrá iniciar Servicio Social.
        </p>
        <p>
        <?php if (count($alumnos) > 1): ?>
            Los estudiantes deben
     <?php else: ?>
        El estudiante debe
   <?php endif; ?>
             guardar estricta confidencialidad de la información proporcionada por <?= htmlspecialchars($nombreFormateado, ENT_QUOTES, 'UTF-8') ?>, además de cumplir con las actividades y horarios establecidos, por lo que cualquier anomalía debe ser comunicada de inmediato al Coordinador de Servicio Social al 7861-6798.
        </p>
        <p>
        <?php if (count($alumnos) > 1): ?>
            Los estudiantes deben llegar identificados
     <?php else: ?>
        El estudiante debe llegar identificado
   <?php endif; ?>
             con camisa UNIVO durante la ejecución del Servicio Social, cuando este es contabilizado por hora. Y solicitamos se dé acceso a las instalaciones de la institución para que el personal de la UNIVO realice supervisión y evaluación
             <?php if (count($alumnos) > 1): ?>
                de los estudiantes.
     <?php else: ?>
        del estudiante.
   <?php endif; ?>
             
        </p>
        <p>
            Al finalizar el Servicio Social se deberá remitir constancia de finalización de Servicio Social
            <?php if (count($alumnos) > 1): ?>
                a los estudiantes,
     <?php else: ?>
        al estudiante, 
   <?php endif; ?>
             con base al formato que se les proporciona en la Unidad de Servicio Social, y que debe ser adaptado con el membrete de la institución que usted representa.
        </p>

        <table class="table">
            <tr>
                <th class="table-title" colspan="5">TABLA 2. DATOS DE CONTACTOS DE LA IES</th>
            </tr>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Gabriela Patricia Díaz García</td>
                <td>Coordinadora de Servicio Social</td>
                <td>2645 0403</td>
                <td>serviciosocial@univo.edu.sv</td>
            </tr>
        </table>
        <p>Atentamente, </p>
        <?php if (count($alumnos) <= 3): ?>
    <br>
    <br>
<?php endif; ?>
        <br>
        <p class="center-text">
        <?= $coordinador['nombre'] ?> <br>
        <?= $coordinador['cargo'] ?>
        </p>
    </div>

    <div class="footer">
        <img src="/img/image2.png" alt="Footer Image">
    </div>
</body>
</html>
