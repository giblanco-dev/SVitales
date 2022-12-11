<?php 
require_once 'conn.php';
$id_paciente = $_GET['idp'];
$nom_paciente = $_GET['nom_paciente'];
$sql_hoja_enfermeria = "
                        SELECT cita.fecha, cita.id_cita, CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_Paciente, 
                        CONCAT(user.nombre,' ',user.apellido) Medico, 
                        cita.id_paciente, consulta.ta, consulta.temp, consulta.fre_c, consulta.fre_r, 
                        consulta.oxi, consulta.peso, consulta.talla, consulta.edad, consulta.alergias, 
                        consulta.nota_enfermeria, consulta.act_nota_enfermeria 
                        FROM cita 
                        INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente 
                        INNER JOIN consulta ON cita.id_cita = consulta.id_cita 
                        LEFT OUTER JOIN user ON cita.medico = user.id 
                        where cita.id_paciente = '$id_paciente' and pagado = 1 ORDER BY cita.fecha DESC";
        $res_sql_hoja = $mysqli->query($sql_hoja_enfermeria);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Hoja de Enfermería</title>
    <link rel="shortcut icon" href="../ser/static/img/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <br>
                <h5>Hoja de Enfermería del Paciente: <?php echo $nom_paciente ?> 
                <span style="float: right;">Expediente Sistema: <?php echo $id_paciente; ?></span></h5>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                <table class="table-bordered border-dark" style="font-size: 16px;">
                    <thead>
                        <tr>
                            <th>Fecha Cita</th>
                            <th>T/A</th>
                            <th>Fre. C</th>
                            <th>Fre. R</th>
                            <th>Oxígeno</th>
                            <th>Temp</th>
                            <th>Peso</th>
                            <th>Talla</th>
                            <th>Edad</th>
                            <th>Alergias</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    <?php 
                    while($row = mysqli_fetch_assoc($res_sql_hoja)){
                        $fecha_format = date("d-m-Y", strtotime($row['fecha']));
                        ?>
                        <tr>
                            <td style="font-size: 16px;"><?php echo $fecha_format; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['ta']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['fre_c']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['fre_r']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['oxi']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['temp']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['peso']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['talla']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['edad']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['alergias']; ?></td>
                            <td style="font-size: 16px;"><?php echo $row['nota_enfermeria']; ?></td>
                            
                        </tr>

                    <?php
                    }         
                ?>
                    </tbody>
                </table>
               
            </div>
        </div>
    </div>
</body>
</html>