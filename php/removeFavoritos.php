<?php

session_start();

$v_id_filme = $_POST['id_filme']; 

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

$queryremoveFavorito = "DELETE FROM favoritosUsuario WHERE id_usuario = " . $_SESSION['usuario']['id_usuario'] . " AND id_filme = " . $v_id_filme; 
mysqli_query($mysqli,$queryremoveFavorito);

?>