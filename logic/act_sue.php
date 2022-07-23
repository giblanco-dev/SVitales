<?php 
require_once '../conn.php';

if(!empty($_POST)){

    $id_registro = $_POST['id_suero'];
    $id_cita = $_POST['id_cita'];
    $nom_paciente = $_POST['nom_paciente'];
    $enfermera = $_POST['enfermera'];

    $sql_act_suero = "UPDATE rec_sueros SET aplicado = 1, aplicado_por = '$enfermera' where id_registro = '$id_registro'";
    if($mysqli->query($sql_act_suero) === TRUE){
        echo '<script type="text/javascript" async="async">window.location.href="../ver_sueros.php?idc='.$id_cita.'&np='.$nom_paciente.'"</script>';
    }else{
        echo '<a onclick="window.close();">Ocurrió un error al actualizar notificar a Sistemas. Cerrar</a>';
    }
}else{
    echo '<a onclick="window.close();">Ocurrió un error notificar a Sistemas. Cerrar</a>';
}
    
?>