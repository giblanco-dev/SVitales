<?php
session_start();

// Si ya hay sesión iniciada, redirigir a inicio.php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: inicio.php");
    exit;
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    // Contraseña por defecto (puedes cambiarla aquí)
    if ($password === 'ser2026') {
        $_SESSION['logged_in'] = true;
        header("Location: inicio.php");
        exit;
    } else {
        $error = "Contraseña incorrecta";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Signos Vitales</title>
    <link rel="shortcut icon" href="static/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="static/css/materialize.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('../ser/static/img/background_login.png'); 
            background-size: cover;
            background-color: #f5f5f5;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="login-box center-align">
        <img src="static/img/banner_2.png" class="responsive-img" style="margin-bottom: 20px;" alt="Logo" onerror="this.style.display='none'">
        <h5>Acceso a Signos Vitales</h5>
        <form method="POST" action="">
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="password" type="password" name="password" required>
                <label for="password">Contraseña</label>
            </div>
            <?php if($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <button class="btn waves-effect waves-light" type="submit" style="margin-top: 15px;">Ingresar
                <i class="material-icons right">send</i>
            </button>
        </form>
    </div>
    
    <script type="text/javascript" src="static/js/jquery-3.3.1.min.js"></script>
    <script src="static/js/materialize.js"></script>
</body>
</html>
