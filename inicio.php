<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit;
}
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
    <link rel="shortcut icon" href="static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="static/css/materialize.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="static/js/jquery-3.3.1.min.js"></script>
    <script src="static/js/materialize.js"></script>
    <style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive-2 { 
            height: 450px; /* Mover a 400 para demostrar el scroll*/
            overflow-y:scroll;
        }
    </style>
</head>
<body style="background-image: url('static/img/background_login.png'); background-size: cover;">
    <div>
        <div class="row grey lighten-3">
        
        <div class="col s5 center-align">
        <img src="static/img/banner_2.png" class="responsive-img">
        </div>
        <div class="col s4"></div>
        <div class="col s3">
            <div class="row" style="width: auto;">
            <div class="input-field col s12 grey lighten-3 center-align">
          <i class="material-icons prefix">search</i>
          <input id="search" type="text">
          <label for="search">Buscar pacientes</label>
          </div>
            </div>
        </div>
        </div>
    </div>
        <div class="row grey lighten-3" style="margin-top: 1%;">
        <div class="col s4 center-align" style="display: flex; align-items: center; justify-content: center;">
            <a href="inicio.php"><h4>Actualizar <i class="small material-icons">autorenew</i></h4></a>
        
        </div>
        <div class="col s4 center-align" style="display: flex; align-items: center; justify-content: center;">
        <h4 style="margin-right: 20px;"><b>Captura de Signos Vitales</b></h4>
        </div>
        <div class="col s4 grey lighten-3 center-align">
        <a href="logout.php" class="btn red waves-effect waves-light" style="margin-top: 20px;"><i class="material-icons left">exit_to_app</i>Cerrar Signos Vitales</a>
        </div>
        </div>
        <div>
        <div class="col s12 grey lighten-3 center-align table-responsive-2">
        <table id="mytable">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>T/A</th>
                    <th>FRE C</th>
                    <th>FRE R</th>
                    <th>Oxígeno</th>
                    <th>Temp</th>
                    <th>Peso</th>
                    <th colspan="2">Edad</th>
                    <th>Talla</th>
                    <th>Alergias</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="center-align">
                <?php
                while($citas = mysqli_fetch_assoc($result_citas)){ ?>
                <tr>
                    <td style="text-transform: capitalize;"><b><?php echo $citas['Nom_paciente']; ?></b></td>
                    <form action="update_svitales.php" method="POST" autocomplete="off">
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
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.1" required name="fc" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.1" required name="fr" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number"  required name="oxi" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.01" required name="temp" min="1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number"  required name="peso" min="1" step="0.1"></td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" required name="edad" min="1"></td>
                    <td>
                    <p>
                        <label>
                            <input name="periodo" type="radio" value="meses"/>
                            <span>Meses</span>
                        </label>
                        </p>
                    <p>
                        <label>
                            <input name="periodo" type="radio" value="años" />
                            <span>Años</span>
                        </label>
                        </p>
                    </td>
                    <td><input style="font-size: 14px; width: 50px;" type="number" step="0.01" required name="talla" min="1"></td>
                    
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
        <script>
 // Write on keyup event of keyword input element
 $(document).ready(function(){
 $("#search").keyup(function(){
 _this = this;
 // Show only matching TR, hide rest of them
 $.each($("#mytable tbody tr"), function() {
 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
 $(this).hide();
 else
 $(this).show();
 });
 });
});
</script>
</body>
</html>