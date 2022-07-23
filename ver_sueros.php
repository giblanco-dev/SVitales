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
            <h5>Sueros Cita <?php echo $id_cita; ?> Paciente: <?php echo $nom_paciente; ?></h5>
        </div>
        <div class="col s12">
<?php 
$sql_rec_sueros = "SELECT sueros.nom_suero, aplicado, aplicado_por,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp1) Complemento1,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp1) Precio1,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp2) Complemento2,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp2) Precio2,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp3) Complemento3,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp3) Precio3,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp4) Complemento4,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp4) Precio4,
(Select complementos.nom_complemento from complementos WHERE complementos.id_comple = rec_sueros.comp5) Complemento5,
(Select complementos.precio from complementos WHERE complementos.id_comple = rec_sueros.comp5) Precio5,
rec_sueros.cancelado, rec_sueros.id_registro, enfermeras.nom_enfermera
FROM rec_sueros
INNER JOIN sueros on rec_sueros.suero = sueros.id_suero
INNER JOIN enfermeras on rec_sueros.aplicado_por = enfermeras.clave
WHERE rec_sueros.id_cita = '$id_cita' and cancelado = 0";
$result = $mysqli->query($sql_rec_sueros);
$val_sueros = $result->num_rows;

if($val_sueros > 0){
    echo '<br><h5>Sueros-Complementos Registrados</h5>
    <table class="centered">
    <tr>
        <th><b>Suero</b></th>
        <th colspan="5"><b>Complementos</b></th>
        <th><b>Enfermera que aplica</b></th>
        <th><b>Aplicado</b></th>
      </tr>';
      $total = 0;
    while($row = mysqli_fetch_assoc($result)){
        if($row['aplicado'] == 0){
            $print = '<button class="waves-effect waves-light btn-small" type="submit" name="action">Pendiente
                    </button>';
        }else{
            $print = 'Suero Aplicado';
        }
        if($row['aplicado_por'] != ''){
            $print2 = $row['nom_enfermera'];
        }else{
            $print2 = '<input type="password" name="enfermera" required>';
        }

        echo'
        <tr>
        <td>'.$row['nom_suero'].'</td>
        <td>'.$row['Complemento1'].'</td>
        <td>'.$row['Complemento2'].'</td>
        <td>'.$row['Complemento3'].'</td>
        <td>'.$row['Complemento4'].'</td>
        <td>'.$row['Complemento5'].'</td>
        <form action="logic/act_sue.php" method="POST">
                    <input type="hidden" name="id_suero" value="'.$row['id_registro'].'">
                    <input type="hidden" name="id_cita" value="'.$id_cita.'">
                    <input type="hidden" name="nom_paciente" value="'.$nom_paciente.'">
                    <td>'.$print2.'</td>
                    <td>'.$print.'</td>
                    </form>
        </tr>';
    }
        echo'
        </table>';
}else{
    echo '<h5>Aún no hay registros de sueros de la cita Actual</h5>';
}
?>
</div>
        
 
 <div class="col s12 center align" style="margin-top: 3%;">
 <a class="btn" onclick="window.close();"><i class="material-icons right">close</i>Cerrar</a>
 </div>

</div>
    </div>
</body>
</html>