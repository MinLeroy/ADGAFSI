<?php
session_start();
/* USUARIO Y CONTRASEÑA DEFINIDOS */
$usuario_valido = "Admin";
$contrasena_valida = "Hifiber123"; 

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
    $contrasena = filter_input(INPUT_POST, 'contrasena', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
        $_SESSION["usuario"] = $usuario;
  
        header("Location: home.php?page=panel"); 
        
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADGAFSI - Iniciar Sesión</title>
    <link rel="stylesheet" href="visual/css/style.css"> 
</head>
<body>
    
    <div id="splash-screen">
        <img src="visual/img/logo_hifiber.png" alt="Logo HiFiber" class="splash-logo">
        <div class="splash-text">HIFIBER. Sistema ADGAFSI<br><br></div>
        <div class="spinner"></div> 
    </div>

    <div class="login-container hidden" id="login-section">
        <div class="login-card">
            
            <img src="visual/img/logo_hifiber.png" alt="Logo HiFiber" class="logo">
            
            <h1 class="main-title">Iniciar Sesión</h1>
            
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form">
                
                <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                    
                <button type="submit" class="btn-login">
                    INICIAR SESIÓN
                </button>

            </form>
        </div>
    </div>

    <script>
        window.addEventListener('load', () => {
            const splashScreen = document.getElementById('splash-screen');
            const loginSection = document.getElementById('login-section');

            setTimeout(() => {
                splashScreen.style.opacity = '0'; 
                
                
                splashScreen.addEventListener('transitionend', () => {
                    splashScreen.style.display = 'none'; 
                    
                   
                    loginSection.classList.remove('hidden'); 
                    loginSection.classList.add('visible');
                });
            }, 1500); 
        });
    </script>
</body>
</html>