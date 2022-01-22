<?php
require_once 'conn.php';

$hoy = date("Y-m-d");

$sql_citas = "SELECT cita.id_cita, cita.id_paciente, paciente.id_paciente, 
CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_paciente,
CONCAT(user.nombre,' ',user.apellido) medico_cita, cita.fecha, cita.horario, cita.tipo, tipos_cita.descrip_cita, confirma, consulta.peso
    FROM cita
    INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
    INNER JOIN tipos_cita on cita.tipo = tipos_cita.id_tipo_cita
    INNER JOIN consulta on cita.id_cita = consulta.id_cita
    LEFT JOIN user on cita.medico = user.id
     WHERE cita.fecha = '$hoy' AND confirma = 2 and peso = 'x'
    ORDER BY cita.fecha, cita.horario";

$result_citas = $mysqli-> query($sql_citas);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signos Vitales</title>
    <link rel="shortcut icon" href="../ser/static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../ser/static/css/materialize.css">
    <link rel="stylesheet" href="../ser/static/icons/iconfont/material-icons.css">
    <script src="../ser/static/js/materialize.js"></script>
    <script type="text/javascript" src="../ser/static/js/jquery-3.3.1.min.js"></script>
</head>
<body style="background-image: url('../ser/static/img/background_login.png'); background-size: cover;">
    <div class="container">
        <div class="row" style="margin-top: 1%;">
        <div class="col s12 center-align">
        <img src="../ser/static/img/banner_2.png" class="responsive-img z-depth-5">
        </div>
        </div>
    </div>
        <div class="row" style="margin-top: 1%;">
        <div class="col s8 grey lighten-3 center-align">
        
        <h4><b>Captura de Signos Vitales</b></h4>
        </div>
        <div class="col s4 grey lighten-3 center-align">
        <a href="http://localhost/svitales/"><h4>Actualizar <i class="small material-icons">autorenew</i></h4></a>
        </div>
        </div>
        <div>
        <div class="col s12 grey lighten-3 center-align">
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>T/A</th>
                    <th>TEMP</th>
                    <th>FRE C</th>
                    <th>FRE R</th>
                    <th>Peso</th>
                    <th>Talla</th>
                    <th>Edad</th>
                    <th>Alergias</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="center-align">
                <?php
                while($citas = mysqli_fetch_assoc($result_citas)){ ?>
                <tr>
                    <td style="text-transform: capitalize;"><b><?php echo $citas['Nom_paciente']; ?></b></td>
                    <form action="update_svitales.php" method="POST">
                    <td>
                    <div class="row">
                    <div class="col s5">
                    <input style="font-size: 14px; width: 50px;" type="number" required name="ta1" min="1">
                    </div>
                    <div class="col s2"><p>/</p></div>
                    <div class="col s5">
                    <input style="font-size: 14px; width: 50px;" type="number" required name="ta2" min="1">
                    </div>
                    </div>
                    </td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.1" required name="temp" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.1" required name="fc" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.1" required name="fr" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.1" required name="peso" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.01" required name="talla" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" required name="edad" min="1"></td>
                    <td><input style="font-size: 14px;" type="text" required name="alergias"></td>
                    <td class="center-align"><button class="btn waves-effect waves-light" type="submit" name="action">Enviar
                    <input type="hidden" name="id_cita" value="<?php echo $citas['id_cita'];?>">
                    <i class="material-icons right">send</i>
                    </button></td>
                    </form>
                </tr>

                <?php   }
                ?>
            </tbody>
        </table>
        <form action="app/logic/session.php" class="col s12"  method="POST">
        </form>
        
        <p style="margin-bottom: 18px;" >© Copyright 2022</p>
    </div>
        </div>
   
</body>
</html>