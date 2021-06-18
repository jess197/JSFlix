<?php
    $mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

    if($mysqli -> connect_errno){
        echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
        exit(); 
    }

    $filme_titulo = $_POST['filme_titulo'];
    $filme_genero = $_POST['filme_genero'];
    $filme_ano = $_POST['filme_ano'];
    $filme_duracao = $_POST['filme_duracao'];
    $filme_relevancia = $_POST['filme_relevancia'];
    $filme_sinopse = $_POST['filme_sinopse'];
    $filme_trailer = $_POST['filme_trailer'];


    if($_FILES['file']['name'] != ''){
        $filme_capa = $_FILES['file']['name'];

        $location = '../images/'.$filme_capa;
        move_uploaded_file($_FILES['file']['tmp_name'], $location);


        $queryCadastro = "INSERT INTO filme(titulo,id_genero,ano,duracao,relevancia,sinopse,trailer,imagem) VALUES('".$filme_titulo."',".$filme_genero.",".$filme_ano.",".$filme_duracao.",".$filme_relevancia.",'".$filme_sinopse."','".$filme_trailer."','".$filme_capa."');";
        mysqli_query($mysqli,$queryCadastro);

        $retorno['sucesso'] = true;
        $retorno['mensagem'] = 'Cadastro realizado com sucesso';
    }
    echo json_encode($retorno);
?> 