<?php

session_start();

$v_id_filme = $_POST['id_filme']; 

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

$queryaddFavorito = "INSERT INTO favoritosUsuario(id_usuario,id_filme) VALUES (" . $_SESSION['usuario']['id_usuario'] ."," . $v_id_filme . ")"; 
mysqli_query($mysqli,$queryaddFavorito);





?>