<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Consulta</title>
    <link rel="shortcut icon" href="../ser/static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../ser/static/css/materialize.css">
    <script type="text/javascript" src="../ser/static/js/jquery-3.3.1.min.js"></script>
    <script src="../ser/static/js/sweetalert.min.js"></script>
</head>
<body style="background-image: url('../ser/static/img/background_login.png'); background-size: cover;">
    
<?php 
require_once 'conn.php';

if(!empty($_POST)){
    $id_cita = $_POST['id_cita'];
    $t_a = $_POST['ta'];
    $temp = $_POST['temp'];
    $f_c = $_POST['fc'];
    $f_r = $_POST['fr'];
    $peso = $_POST['peso'];
    $talla = $_POST['talla'];

    $sql_svitales = "UPDATE consulta SET ta = '$t_a', temp = '$temp', fre_c = '$f_c', fre_r = '$f_r', peso = '$peso', talla = '$talla'
                     WHERE id_cita = '$id_cita'";

    if($mysqli->query($sql_svitales) === TRUE){
        echo '<script type="text/javascript">
        swal({
            title: "Listo!",
            text: "Se guardaron los signos vitales de la Cita_CSA'.$id_cita.'",
            icon: "success",
            button: "Volver",
          }).then(function() {
            window.location = "index.php";
        });
        </script>';
    }else{
        echo '<script type="text/javascript" async="async">alert("Ha ocurrido un error, intente nuevamente \n , de lo contrario contacte con el administrador del sistema");window.location.href="index.php"</script>';
    }
}
?>
</body>
</html>