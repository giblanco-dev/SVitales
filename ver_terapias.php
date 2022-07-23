<?php 
$id_cita = $_GET['idc'];
$nom_paciente = $_GET['np'];

//echo $id_cita;

require 'conn.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapias</title>
    <link rel="shortcut icon" href="../ser/static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../ser/static/css/materialize.css">
    <link rel="stylesheet" href="../ser/static/icons/iconfont/material-icons.css">
    <script src="../ser/static/js/materialize.js"></script>
    <script type="text/javascript" src="../ser/static/js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div class="row">
        <div class="col s12 center-align">
            <h5>Terapias Cita <?php echo $id_cita; ?> Paciente: <?php echo $nom_paciente; ?></h5>
        </div>
        <div class="col s12">
<?php 
    $sql_total = "SELECT id_registro, terapia, indicaciones, no_terapias, aplicado, enfermeras.nom_enfermera, aplicado_por
                    FROM rec_terapias 
                    INNER JOIN enfermeras on rec_terapias.aplicado_por = enfermeras.clave
                    WHERE id_cita = '$id_cita' and cancelado = 0";
    $res_tot_ter = $mysqli->query($sql_total);
    $tot_ter = $res_tot_ter-> num_rows;

    if($tot_ter > 0){
        echo '
                <table>
                <tr>
                    <td><b>Terapia</b></td>
                    <td><b>Cantidad</b></td>
                    <td><b>Indicaciones</b></td>
                    <td><b>Enfermera que aplica</b></td>
                    <td>Aplicado</td>
                  </tr>
                ';
        while($ter_reg = mysqli_fetch_assoc($res_tot_ter)){

            if($ter_reg['aplicado'] == 0){
                $print = '<button class="waves-effect waves-light btn-small" type="submit" name="action">Pendiente
                        </button>';
            }else{
                $print = 'Terapia Aplicada';
            }
            if($ter_reg['aplicado_por'] != ''){
                $print2 = $ter_reg['nom_enfermera'];
            }else{
                $print2 = '<input type="password" name="enfermera" required>';
            }
            
            echo '<tr>
                    <td>'.$ter_reg['terapia'].'</td>
                    <td>'.$ter_reg['no_terapias'].'</td>
                    <td>'.$ter_reg['indicaciones'].'</td>
                    <form action="logic/act_ter.php" method="POST">
                    <input type="hidden" name="id_terapia" value="'.$ter_reg['id_registro'].'">
                    <input type="hidden" name="id_cita" value="'.$id_cita.'">
                    <input type="hidden" name="nom_paciente" value="'.$nom_paciente.'">
                    <td>'.$print2.'</td>
                    <td>'.$print.'</td>
                    </form>
                    ';
                    
        }
        echo '</table>';
                
    }else{
        echo '<h5>Error no hay terapias notificar a Sistemas</h5>';
    }

?>
 <div class="row" style="margin-top: 3%;">
 <div class="col s12 center align">
 <a class="btn" onclick="window.close();"><i class="material-icons right">close</i>Cerrar</a>
 </div>
 </div>
</div>
    </div>
</body>
</html>