<?php
//
session_start();
session_unset(); //vaciar la boveda
session_destroy(); //elimina la boveda y elimina la llave
header("Location: sesion1.php"); //redireccionando
exit; //deteniendo la ejecucion del script

?>