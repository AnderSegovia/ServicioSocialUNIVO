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
            font-size: 11pt;
            margin: 0; /* Eliminar margen del body */
            padding: 0; /* Eliminar padding del body */
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
            padding-top: 0.5cm; /* Espacio en la parte superior */
        }
        .content p {
            line-height: 1.5; 
            letter-spacing: -0.2px;
        }
        .table-container {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container th, .table-container td {
            text-align: center;
            vertical-align: top;
        }
        .table-container td {
            text-align: left;
        }
        .table-container th:nth-child(1),
        .table-container td:nth-child(1) {
            width: 41%;
        }
        .table-container th:nth-child(2),
        .table-container td:nth-child(2) {
            width: 39%;
        }
        .table-container th:nth-child(3),
        .table-container td:nth-child(3) {
            width: 20%;
        }
        .firmas {
            z-index: 1;
            width: 100%;
            margin-top: 1.5cm;
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
    <div class='content'>
        <p>EL SUSCRITO DIRECTOR DE VINCULACIÓN SOCIAL DE LA UNIVERSIDAD DE ORIENTE, CERTIFICA QUE:</p>           

        <p><?= $genero == 1 ? 'La' : 'El' ?> <?= $titulo ?> <strong><?= mb_strtoupper($nombreFormateadoEstudiante, 'UTF-8') ?></strong> con código <strong><?= $alumno->codigo ?></strong> <?= $genero == 1 ? 'inscrita' : 'inscrito' ?> en la carrera <strong><?= mb_strtoupper($alumno->fkCarrera->nombre_carrera, 'UTF-8') ?></strong> de la <strong><?= mb_strtoupper($alumno->fkCarrera->fkFacultad->nombre_facultad, 'UTF-8') ?></strong> de la <strong>UNIVERSIDAD DE ORIENTE,</strong> ha cumplido satisfactoriamente con el Servicio Social requerido según el Reglamento de la Universidad de Oriente.</p>
        

        <?php if($datosAdicionales['tipo']== 2){ ?>
                    <table class='table-container' style='font-size: 10pt;'>
                        <?php }else{ ?>
                    <table class='table-container'>
                    <?php }?>
            <thead>
                <tr>
                    <th style="vertical-align: middle;">NOMBRE DEL PROYECTO</th>
                    <th style="vertical-align: middle;">ACTIVIDAD</th>
                    <th style="vertical-align: middle;">HORAS POR ACTIVIDAD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="<?= count($actividades) ?>" style="vertical-align: middle;">
                        <?= $datosAdicionales['nombreProyecto'] ?> <br>
                        Institución: <?= $nombreFormateado ?>.<br>
                        Distrito: <?= $institucion->fkDistritoInst->nombre_distrito ?>.<br>
                        Departamento: <?= $institucion->fkDistritoInst->fkMunicipio->fkDepartamento->nombre_departamento ?>.<br>
                        Periodo de ejecución: del <?= $fromDate ?> al <?= $toDate ?>.
                    </td>
                    <td>
                        <?= htmlspecialchars($actividades[0]['junta']) ?>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <?= htmlspecialchars($actividades[0]['horas']) ?>
                    </td>
                </tr>

                <?php for ($i = 1; $i < count($actividades); $i++): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($actividades[$i]['junta']) ?>
                    </td>
                    <td style=" text-align: center; vertical-align: middle;">
                        <?= htmlspecialchars($actividades[$i]['horas']) ?>
                    </td>
                </tr>
                <?php endfor; ?>

                <?php
                if($datosAdicionales['tipo']== 2){
                ?>

                <tr >
                    <td rowspan="<?= count($actividades2) ?>">
                        <div style=" vertical-align: middle;">
                                <?= $datosAdicionales['campo2'] ?>
                                Institución: <?= $nombreFormateado2 ?>.<br>
                                Distrito: <?= $institucion2->fkDistritoInst->nombre_distrito ?>.<br>
                                Departamento: <?= $institucion2->fkDistritoInst->fkMunicipio->fkDepartamento->nombre_departamento ?>.<br>
                                Periodo de ejecución: del <?= $fromDate2 ?> al <?= $toDate2 ?>.
                            </td>
                            <td>
                                <?= htmlspecialchars($actividades2[0]['junta2']) ?>
                            </td>
                            <td style=" text-align: center; vertical-align: middle;">
                                <?= htmlspecialchars($actividades2[0]['horas2']) ?>
                            </td>
                        </div>

                </tr>
                <?php for ($i = 1; $i < count($actividades2); $i++): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($actividades2[$i]['junta2']) ?>
                    </td>
                    <td style=" text-align: center; vertical-align: middle;">
                        <?= htmlspecialchars($actividades2[$i]['horas2']) ?>
                    </td>
                </tr>
                <?php endfor; } ?>


                <tr>
                    <td style=" border: none; height: 0.3cm; padding: 0; line-height: 0;"></td>
                    
                    <td style=" border: none; height: 0.3cm; padding: 0; line-height: 0; font-size: 11pt;"> <strong> Total de Horas </strong> </td>
                    <td style="height: 0.3cm; padding: 0; line-height: 0; font-size: 11pt;  text-align: center;">
                        <?php if( $alumno->fkCarrera->id_carrera == 56){
                            echo "200";
                        }else{
                                echo"500";
                            } ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>Y para ser presentada en la JUNTA DE VIGILANCIA DE LA PROFESIÓN EN PSICOLOGÍA, firma y sella la presente en la ciudad de San Miguel, <?= $fecha ?>.</p> 
    </div>
    <div class='firmas'>
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
        <p style="font-size: 10pt;">AC.</p>
    </div>
</body>
</html>
