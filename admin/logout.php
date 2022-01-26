<?php
session_start();

// --- CIERRA SESIÓN ----------------------------------------------------------------------------------------------------------------------------------------------------------------->

# Elimina todas las variables de sesión establecidas
$_SESSION = array();

# Destruye sesión completa
unset($_COOKIE['tiempoUsuario2']);
session_destroy();

# Destruye cookie de sesión que contiene el ID de sesión
# ( ésta cookie también se borra al cerrar el navegador )

$name= session_name();                                              // Get name of session cookie
$expire = strtotime('-1 year');                                     // Create expire date in the past
$params = session_get_cookie_params();                              // Get session params
$path = $params['path'];
$domain = $params['domain'];
$secure = $params ['secure'];
$httponly = $params['httponly'];
setcookie($name, '', $expire, $path, $domain, $secure, $httponly);

header("location: ../../index.php");

?>