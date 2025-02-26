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
            <?php
                if($datosAdicionales['tipo']== 1){
                    echo "<div class='content' style='padding-top: 1cm; '>";
                }else{
                    echo "<div class='content' style='padding-top: 0.5cm; '>";
                }
                ?>
    
    <p>EL SUSCRITO DIRECTOR DE VINCULACIÓN SOCIAL DE LA UNIVERSIDAD DE ORIENTE, CERTIFICA QUE:</p>           
<br>


    <p><?= $genero == 1 ? 'La' : 'El' ?> <?= $titulo ?> <strong><?= mb_strtoupper($nombreFormateadoEstudiante, 'UTF-8') ?></strong> con código <strong><?= $alumno->codigo ?></strong> <?= $genero == 1 ? 'inscrita' : 'inscrito' ?> en la carrera de <strong><?= mb_strtoupper($alumno->fkCarrera->nombre_carrera, 'UTF-8') ?></strong> de la <strong><?= mb_strtoupper($alumno->fkCarrera->fkFacultad->nombre_facultad, 'UTF-8') ?></strong> de la <strong>UNIVERSIDAD DE ORIENTE,</strong>
    <?php
    if($datosAdicionales['tipo']==3){
    ?> con base en el artículo 18 literal “C” del Reglamento de Servicio Social de la Universidad de Oriente, que literalmente establece que: “Los graduados de la Universidad de Oriente y otras Instituciones de Educación Superior que realicen plan complementario o segunda carrera realizarán doscientas horas sociales”, ha cumplido satisfactoriamente con el Servicio Social requerido según el Reglamento de la Universidad de Oriente.
    <?php
    }else{
    ?> ha cumplido satisfactoriamente con el Servicio Social requerido según el Reglamento de la Universidad de Oriente.</p>
<?php
    }
    ?>
<?php if($datosAdicionales['tipo']== 1){ ?>
        <table class="table-container" style="margin-top: 0.3cm; margin-bottom: 0.3cm;">
        <?php }else{  ?>
            <table class="table-container" >
                <?php } ?>
            <tr>
                <th style="vertical-align: middle;">INSTITUCIÓN</th>
                <th style="vertical-align: middle;">NOMBRE DEL PROYECTO</th>
                <th>TOTAL DE HORAS</th>
            </tr>
            <?php
                if($datosAdicionales['tipo']== 2){
                ?>
            <tr>
                <td style="text-align: left;  height: 4.5cm; width: 45%;">
                <?= $nombreFormateado ?>.<br>
                    Distrito: <?= $institucion->fkDistritoInst->nombre_distrito ?>.<br>
                    Departamento: <?= $institucion->fkDistritoInst->fkMunicipio->fkDepartamento->nombre_departamento ?>.<br>
                    Periodo de ejecución: del <?= $fromDate ?> al <?= $toDate ?>.
                </td>
                <td style="text-align: left; width: 45%;"><?= $datosAdicionales['nombreProyecto'] ?></td>
                <td style="vertical-align: middle; width: 10%;">250</td>
            </tr>
            <tr>
                <td style="text-align: left; height: 4.5cm;  width: 45%;">
                <?= $nombreFormateado2  ?>.<br>
                    Distrito: <?= $institucion2->fkDistritoInst->nombre_distrito ?>.<br>
                    Departamento: <?= $institucion2->fkDistritoInst->fkMunicipio->fkDepartamento->nombre_departamento ?>.<br>
                    Periodo de ejecución: del <?= $fromDate2 ?> al <?= $toDate2 ?>.
                </td>
                <td style="text-align: left; width: 45%;"><?= $datosAdicionales['campo2'] ?></td>
                <td style="vertical-align: middle;  width: 10%;">250</td>
            </tr>
            <tr>
    <td style=" border: none; height: 0.3cm; padding: 0; line-height: 0;"></td>
    <td style=" border: none; height: 0.3cm; padding: 0; line-height: 0;"></td>
    <td style="height: 0.3cm; padding: 0; line-height: 0; font-size: 11pt;">
        500
    </td>
</tr>

                <?php }else{?>
            <tr>
                <td style="text-align: left;">
                <?= $nombreFormateado ?>.<br>
                    Distrito: <?= $institucion->fkDistritoInst->nombre_distrito ?>.<br>
                    Departamento: <?= $institucion->fkDistritoInst->fkMunicipio->fkDepartamento->nombre_departamento ?>.<br>
                    Periodo de ejecución: del <?= $fromDate ?> al <?= $toDate ?>.
                </td>
                <td style="text-align: left;"><?= $datosAdicionales['nombreProyecto'] ?></td>
                <?php
                if($datosAdicionales['tipo']==1 ){
                    echo "<td style='vertical-align: middle;'>". $alumno->fkCarrera->cant_horas. "</td>";
                }else if($datosAdicionales['tipo']==3 ){
                    echo "<td style='vertical-align: middle;'>200</td>";

                }
                ?>
            </tr>
            <?php } ?>
        </table>
        <p>Y para efectos de graduación, se extiende, firma y sella la presente en la ciudad de San Miguel, <?= $fecha ?>.</p> 
    </div>
    <?php
    if(!($datosAdicionales['tipo']==2) ){
        echo "<div class='firmas' style='margin-top: 2cm;'>";
    }else{
        echo "<div class='firmas' style='margin-top: 1.5cm;'>";
    }
    ?>
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
        <?php
    if($datosAdicionales['tipo']==1 ){
        echo "<br>";
        echo "<br>";
    }else if($datosAdicionales['tipo']==3 ){
        echo "<br>";
    }
    ?>
        <p style="font-size: 10pt;"><?= $colaborador['nombre'] ?></p>
    </div>
    
</body>
</html>
