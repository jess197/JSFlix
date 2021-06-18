<?php

session_start();

$v_busca_filme       = $_POST['busca_filme']; 
$v_busca_ano         = $_POST['busca_ano']; 
$v_busca_genero      = $_POST['busca_genero']; 
$v_busca_relevancia  = $_POST['busca_relevancia']; 

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

$query = "SELECT f.id_filme, titulo,g.genero,ano,duracao,relevancia,sinopse,trailer,imagem 
            FROM filme f 
            JOIN genero g 
            ON f.id_genero = g.id_genero 
            WHERE 1 = 1 ";

if(strlen($v_busca_filme) > 0){
    $query .= "AND f.titulo LIKE '%" . $v_busca_filme . "%' ";
}
if(strlen($v_busca_ano) > 0){
    $query .= "AND f.ano = " . $v_busca_ano  . " ";
}
if(strlen($v_busca_genero) > 0){
    $query .= "AND g.id_genero = " . $v_busca_genero  . " ";
}
if(strlen($v_busca_relevancia) > 0){
    $query .= "AND f.relevancia = " . $v_busca_relevancia . " ";
}

//echo $query;
$result = $mysqli -> query($query);

if($result -> num_rows >= 1){
    $retorno = array();
    while ($row = $result->fetch_assoc()) {
       array_push($retorno,$row);
    }

    echo json_encode($retorno);
    
}else{
    echo  $query;
    echo '  Não foram encontrados filmes';
}


?>