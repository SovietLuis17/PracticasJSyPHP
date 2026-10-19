<?php

// crear una cookie 
setcookie("FirstCookie","usuario sin privilegios", time() + 3600, "/");

// pregutarse si la cookie existe
if (isset($_COOKIE['FirstCookie'])) {

 echo "Bienvenido de nuevo ".$_COOKIE['FirstCookie'];

}

?>