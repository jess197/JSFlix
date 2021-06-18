<?php 

session_start();
$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}


if(isset($_SESSION['usuario'])){

    $result = $mysqli -> query("SELECT * FROM dados_pagamento WHERE cpf = \"". $_SESSION["usuario"]["cpf"] ."\"");

    echo json_encode($result->fetch_assoc());

}else{
    echo '';
}




?> 