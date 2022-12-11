<?php 
require 'conn.php';

$hoy = date("Y-m-d");

$sql_sueros = "SELECT nom_suero, SUM(rec_sueros.aplicado) total_aplicados, date(rec_sueros.fecha_registro) fecha_aplicacion
FROM sueros
INNER JOIN rec_sueros ON sueros.id_suero = rec_sueros.suero AND rec_sueros.aplicado = 1
WHERE date(rec_sueros.fecha_registro) = '$hoy'
GROUP BY nom_suero;";

$result_sueros = $mysqli->query($sql_sueros);
$val_sueros = $result_sueros->num_rows;

$sql_terapias = "SELECT nom_terapia, SUM(rec_terapias.aplicado) Total_aplicaciones, date(rec_terapias.fecha_registro) Fecha_aplicacion
FROM terapias
INNER JOIN rec_terapias ON terapias.id_terapia = rec_terapias.id_terapia and rec_terapias.aplicado = 1
WHERE date(rec_terapias.fecha_registro) = '$hoy' 
GROUP BY terapias.id_terapia";

$result_terapias = $mysqli->query($sql_terapias);
$val_terapias = $result_terapias->num_rows;

$sql_complementos = "SELECT id_comple, nom_complemento,
(SELECT COUNT(rec_sueros.comp1) FROM rec_sueros 
 WHERE complementos.id_comple = rec_sueros.comp1 AND rec_sueros.aplicado = 1
 AND date(rec_sueros.fecha_registro) = '$hoy' GROUP BY rec_sueros.comp1) Aplicaciones_comp_1,

 (SELECT COUNT(rec_sueros.comp2) FROM rec_sueros 
 WHERE complementos.id_comple = rec_sueros.comp2 AND rec_sueros.aplicado = 1
 AND date(rec_sueros.fecha_registro) = '$hoy' GROUP BY rec_sueros.comp2) Aplicaciones_comp_2,

 (SELECT COUNT(rec_sueros.comp3) FROM rec_sueros 
 WHERE complementos.id_comple = rec_sueros.comp3 AND rec_sueros.aplicado = 1
 AND date(rec_sueros.fecha_registro) = '$hoy' GROUP BY rec_sueros.comp3) Aplicaciones_comp_3,

  (SELECT COUNT(rec_sueros.comp4) FROM rec_sueros 
 WHERE complementos.id_comple = rec_sueros.comp4 AND rec_sueros.aplicado = 1
 AND date(rec_sueros.fecha_registro) = '$hoy' GROUP BY rec_sueros.comp4) Aplicaciones_comp_4,

  (SELECT COUNT(rec_sueros.comp5) FROM rec_sueros 
 WHERE complementos.id_comple = rec_sueros.comp5 AND rec_sueros.aplicado = 1
 AND date(rec_sueros.fecha_registro) = '$hoy' GROUP BY rec_sueros.comp5) Aplicaciones_comp_5

FROM complementos ORDER BY complementos.id_comple";
$result_complementos = $mysqli->query($sql_complementos);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Terapias y Sueros del día</title>
    <link rel="shortcut icon" href="../ser/static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../ser/static/css/materialize.css">
    <link rel="stylesheet" href="../ser/static/icons/iconfont/material-icons.css">
    <script src="../ser/static/js/materialize.js"></script>
    <script type="text/javascript" src="../ser/static/js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div>
    <div class="row grey lighten-3">
        <div class="col s4">
        <img src="../ser/static/img/banner_2.png" class="responsive-img">
        </div>
        <div class="col s6">
        </div>
        <div class="col s2 center-align"  style="margin-top: 2%;">
        <a onclick="window.close();" class="waves-effect waves-light btn-small"><i class="material-icons right">close</i>Cerrar</a>
        </div>
        </div>
        
        <div class="row">
        <div class="col s4">
                <?php 
                if($val_terapias > 0){
                    ?>
                <table>
                    <thead>
                        <tr class="center-align">
                            <th colspan="2">Terapias aplicadas</th>
                        </tr>
                        <tr>
                            <th>Terapia</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php
                     while($row_terapia = mysqli_fetch_assoc($result_terapias)){
                        ?>
                        <tr>
                            <td><?php echo $row_terapia['nom_terapia']; ?></td>
                            <td><?php echo $row_terapia['Total_aplicaciones']; ?></td>
                        </tr>

                    <?php    }
                     ?>   
                        
                    </tbody>
                </table>
                <?php    }else{
                    echo "<h6>No hay terapias aplicadas el día de hoy</h6>";
                }
                ?>
            </div>
            <div class="col s4">
                <?php 
                if($val_sueros > 0){
                    ?>
                <table>
                    <thead>
                        <tr class="center-align">
                            <th colspan="2">Sueros aplicados</th>
                        </tr>
                        <tr>
                            <th>Suero</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php
                     while($row_sueros = mysqli_fetch_assoc($result_sueros)){
                        ?>
                        <tr>
                            <td><?php echo $row_sueros['nom_suero']; ?></td>
                            <td><?php echo $row_sueros['total_aplicados']; ?></td>
                        </tr>

                    <?php    }
                     ?>   
                        
                    </tbody>
                </table>
                <?php    }else{
                    echo "<h6>No hay sueros aplicados el día de hoy</h6>";
                }
                ?>
            </div>


            <div class="col s4">
                <?php 
                if($val_sueros > 0){
                    ?>
                <table>
                    <thead>
                        <tr class="center-align">
                            <th colspan="2">Complementos de suero aplicados</th>
                        </tr>
                        <tr>
                            <th>Complemneto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php
                     while($row_complemento = mysqli_fetch_assoc($result_complementos)){
                        $val_aplica_compl = $row_complemento['Aplicaciones_comp_1'] + $row_complemento['Aplicaciones_comp_2'] +
                        $row_complemento['Aplicaciones_comp_3'] + $row_complemento['Aplicaciones_comp_4'] + $row_complemento['Aplicaciones_comp_5'];
                        if($val_aplica_compl > 0){
                        ?>
                        <tr>
                            <td><?php echo $row_complemento['nom_complemento']; ?></td>
                            <td><?php echo $val_aplica_compl; ?></td>
                        </tr>

                    <?php    
                        }
                            }
                     ?>   
                        
                    </tbody>
                </table>
                <?php    }else{
                    echo "<h6>Sin Complementos</h6>";
                }
                ?>
            </div>

        </div>


    </div>
    
</body>
</html>