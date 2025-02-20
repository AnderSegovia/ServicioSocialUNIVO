<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia</title>
    <style>
        @page {
            size: 21.59cm 27.94cm; /* Tamaño carta en centímetros */
            margin: 2.5cm 3cm; /* Márgenes: 2.5 cm arriba y abajo, 3 cm izquierda y derecha */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }
        p {
            margin: 0; /* Eliminar margen de los párrafos */
            padding: 0; /* Eliminar padding de los párrafos */
            text-align: justify; /* Alineación justificada para los párrafos */
        }
        .header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/img/image4.png') no-repeat center top;
            background-size: cover; /* Ajustamos el tamaño de la imagen para cubrir todo el contenedor */
            z-index: -1;
        }
        .content {
            z-index: 1;
            padding-bottom: 1cm; /* Espacio en la parte inferior para la firma y la AC. */
        }
        .content p {
            line-height: 1.5; 
            letter-spacing: -0.2px;
        }
        .table-container {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container, .table-container th, .table-container td {
            border: 1px solid black;
        }
        .table-container th, .table-container td {
            padding: 0.1cm;
            text-align: center;
            vertical-align: top;
            line-height: 1.5; /* Interlineado de 1.5 para las celdas de la tabla */
        }
        .table-container th:nth-child(1),
        .table-container td:nth-child(1) {
            width: 37%;
        }
        .table-container td:nth-child(1) {
            width: 37%;
            height: 5.5cm;
        }
        .table-container th:nth-child(2),
        .table-container td:nth-child(2) {
            width: 42%;
        }
        .table-container th:nth-child(3),
        .table-container td:nth-child(3) {
            width: 22%;
        }
        .firmas {
            z-index: 1;
            width: 100%;

        }
        .firmas table {
            width: 100%;
            border: none;
        }
        .firmas td {
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="header"></div>
    <div class='content' style='padding-top: 1.5cm; '>
    <p>EL SUSCRITO DIRECTOR DE VINCULACIÓN SOCIAL DE LA UNIVERSIDAD DE ORIENTE, CERTIFICA QUE:</p>           
    <br> <br>
    <p><?= $genero == 1 ? 'La' : 'El' ?> <?= $titulo ?> <strong><?= mb_strtoupper($alumno->nombre_alumno, 'UTF-8') ?></strong> con código <strong><?= $alumno->codigo ?></strong> <?= $genero == 1 ? 'inscrita' : 'inscrito' ?> en la carrera de <strong><?= mb_strtoupper($alumno->fkCarrera->nombre_carrera, 'UTF-8') ?></strong> de la <strong><?= mb_strtoupper($alumno->fkCarrera->fkFacultad->nombre_facultad, 'UTF-8') ?></strong> de la <strong>UNIVERSIDAD DE ORIENTE,</strong> ha cumplido satisfactoriamente con el Servicio Social requerido según el Reglamento de la Universidad de Oriente desarrollado en <?= $nombreFormateado ?>. En el período comprendido del <?= $fromDate ?> al <?= $toDate ?>.</p>
    <br>         <br>
        <p>Y para efectos de graduación, se extiende, firma y sella la presente en la ciudad de San Miguel, <?= $fecha ?>.</p> 
    </div>
    <br><br><br>
    <div class='firmas' style='margin-top: 2cm;'>
        <table>
            <tr>
            <td>
                    <p><?= $director['nombre'] ?></p>
                    <p><?= $director['cargo'] ?></p>
                </td>
                <td>
                <p><?= $coordinador['nombre'] ?></p>
                <p><?= $coordinador['cargo'] ?></p>
                </td>
            </tr>
        </table>
        <br>
        <br> 
        <br>
        <br>
        <br>
            <br>
            <br>
        <p style="font-size: 10pt;">AC.</p>
    </div>
</body>
</html>
