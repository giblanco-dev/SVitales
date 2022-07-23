<?php 
require_once '../conn.php';

if(!empty($_POST)){

    $nota_enfermeria = $_POST['nota_enf'];
    $id_cita = $_POST['id_cita'];
    $act_nota_enfermeria = $_POST['act_nota'];
    
    $sql_act_nota_consulta = "UPDATE consulta 
                    SET nota_enfermeria = '$nota_enfermeria', act_nota_enfermeria = '$act_nota_enfermeria' 
                    where id_cita = '$id_cita'";
    if($mysqli->query($sql_act_nota_consulta) === TRUE){
        echo '<script type="text/javascript" async="async">window.location.href="../nota_terapia.php"</script>';
    }else{
        echo '<a href="../nota_terapia.php">Ocurrió un error al actualizar notificar a Sistemas. Cerrar</a>';
    }
}else{
    echo '<a href="../nota_terapia.php">Ocurrió un error notificar a Sistemas. Cerrar</a>';
}
    
?>