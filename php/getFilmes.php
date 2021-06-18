<?php 


session_start();

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}


$result = $mysqli -> query("SELECT f.id_filme, titulo,g.genero,ano,duracao,relevancia,sinopse,trailer,imagem,fu.id_usuario FROM filme f JOIN genero g ON f.id_genero = g.id_genero LEFT JOIN favoritosUsuario fu ON f.id_filme = fu.id_filme AND fu.id_usuario = " . $_SESSION['usuario']['id_usuario']);

if($result -> num_rows > 1){
    $retorno = array();
    while ($row = $result->fetch_assoc()) {
       array_push($retorno,$row);
    }

    echo json_encode($retorno);
    
}else{
    echo 'Não há filmes cadastrados';
}

?> 