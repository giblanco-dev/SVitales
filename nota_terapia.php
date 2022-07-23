<?php
require_once 'conn.php';

$hoy = date("Y-m-d");

$sql_citas_ter_sueros = "SELECT
cita.id_cita, CONCAT(paciente.nombres,' ',paciente.a_paterno,' ',paciente.a_materno) Nom_Paciente,
CONCAT(user.nombre,' ',user.apellido) Medico,
COUNT(DISTINCT rec_terapias.id_terapia) Total_Terapias,
COUNT(DISTINCT rec_sueros.id_registro) Total_Sueros,
cita.id_paciente,
consulta.nota_enfermeria,
consulta.act_nota_enfermeria,
enfermeras.nom_enfermera
FROM cita
INNER JOIN paciente ON cita.id_paciente = paciente.id_paciente
INNER JOIN consulta ON cita.id_cita = consulta.id_cita
LEFT OUTER JOIN enfermeras ON consulta.act_nota_enfermeria = enfermeras.clave
LEFT OUTER JOIN user ON cita.medico = user.id
LEFT OUTER JOIN rec_terapias ON cita.id_cita = rec_terapias.id_cita
LEFT OUTER JOIN rec_sueros ON cita.id_cita = rec_sueros.id_cita
WHERE cita.fecha = '$hoy' AND tipo = 0 AND pagado = 1 GROUP BY cita.id_cita";

$result_citas = $mysqli-> query($sql_citas_ter_sueros);



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Enfermería</title>
    <link rel="shortcut icon" href="../ser/static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../ser/static/css/materialize.css">
    <link rel="stylesheet" href="../ser/static/icons/iconfont/material-icons.css">
    <script src="../ser/static/js/materialize.js"></script>
    <script type="text/javascript" src="../ser/static/js/jquery-3.3.1.min.js"></script>
    <script>
        function abrir(url)
          { 
            open(url,'','top=0,left=100,width=900,height=550') ; 
          }
    </script>
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
<body style="background-image: url('../ser/static/img/background_login.png'); background-size: cover;">
    <div>
        <div class="row grey lighten-3">
        <div class="col s4">
        <img src="../ser/static/img/banner_2.png" class="responsive-img">
        </div>
        
        <div class="col s2 center-align" style="margin-top: 2%;">
        <a href="nota_terapia.php" class="waves-effect waves-light btn-small"><i class="material-icons right">autorenew</i>Actualizar</a>
        </div>

        <div class="col s3" style="margin-top: 2%;">
        <a href="resum_suer_ter.php" target="_blank" class="waves-effect waves-light btn-small"><i class="material-icons right">library_books</i>Resumen Terapias y Sueros</a>
        </div>

        <div class="col s3">
            <div class="row" style="width: auto;">
            <div class="input-field col s12 center-align">
          <i class="material-icons prefix">search</i>
          <input id="search" type="text">
          <label for="search">Buscar pacientes</label>
          </div>
            </div>
        </div>
        </div>
    </div>
        <div class="row">
        <div class="col s12 grey lighten-3 center-align">
        
        <h5><b>Pacientes con Terapias y Sueros</b></h5>
        </div>
        </div>
        <div>
        <div>
            <div class="row">
            <div class="col s12 grey lighten-3 center-align table-responsive-2">
        <table id="mytable">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Terapias</th>
                    <th>Sueros</th>
                    <th>Notas Anteriores</th>
                    <th>Nota de Enfermería</th>
                    <th>Enfermera Captura</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="center-align">
                <?php
                while($citas = mysqli_fetch_assoc($result_citas)){ 
                    $id_cita = $citas['id_cita'];
                    $id_paciente = $citas['id_paciente'];
                    $nom_paciente = $citas['Nom_Paciente'];

                    if($citas['nota_enfermeria'] != '' AND $citas['act_nota_enfermeria'] != ''){
                        $print_nota = $citas['nota_enfermeria'];
                        $prin_act_nota = $citas['nom_enfermera'];
                        $action = "";
                    }else{
                        $print_nota = '<input type="text" name="nota_enf" required>';
                        $prin_act_nota = '<input type="password" name="act_nota" required>';
                        $action = '<input type="submit" value="Enviar nota">';
                    }

                    $terapias_sueros = $citas['Total_Terapias'] + $citas['Total_Sueros'];
                    if($terapias_sueros > 0){
                        if($citas['Total_Terapias'] > 0){
                            $flag_terapias = 'Ver Terapias';
                        }else{
                            $flag_terapias = '';
                        }

                        if($citas['Total_Sueros'] > 0){
                            $flag_sueros = 'Ver Sueros';
                        }else{
                            $flag_sueros = '';
                        }

                    ?>
                <tr>
                    <td><?php echo $nom_paciente;  ?></td>
                    <td><?php echo $citas['Medico']  ?></td>
                    <td><a href="javascript:abrir('ver_terapias.php?idc=<?php echo $id_cita; ?>&np=<?php echo $nom_paciente; ?>')"><?php echo $flag_terapias  ?></a></td>
                    <td><a href="javascript:abrir('ver_sueros.php?idc=<?php echo $id_cita; ?>&np=<?php echo $nom_paciente; ?>')"><?php echo $flag_sueros  ?></a></td>
                    <td><a href="hoja_enfermeria.php?idp=<?php echo $id_paciente?>&nom_paciente=<?php echo $nom_paciente ?>" target="_blank">Ver Hoja de Enfermería</a></td>
                    <form action="logic/act_nota_enf.php" method="post">
                    <input type="hidden" name="id_cita" value="<?php echo $id_cita; ?>">
                    <td>
                        <?php echo $print_nota; ?>
                    </td>
                    <td>
                    <?php echo $prin_act_nota; ?>
                    </td>
                    <td><?php echo $action; ?></td>
                    </form>
                </tr>

                <?php   
                    }    
            }
                ?>
            </tbody>
        </table>
        
        
        <p style="margin-bottom: 18px;" >© Copyright 2022</p>
    </div>
            </div>
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