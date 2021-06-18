<?php

$v_email     = $_POST['email']; 
$v_senha     = $_POST['inpassword']; 
$v_confsenha = $_POST['confpassword']; 
$v_token     = $_POST['token'];

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

$v_senhaCripto = hash('sha256',$v_senha); 
$v_confsenhaCripto = hash('sha256',$v_confsenha); 


if(isset($v_token)){
    $token = $v_token; 
    if($token == ''){
        unset($token); 
    }
}


if(!empty($token)){
    if($result = $mysqli -> query("SELECT * FROM recuperacao_senha WHERE token = '" . $token . "'")){

        if($result -> num_rows < 1){
			echo 'Token Inválido';
		}else{
			$row = $result -> fetch_assoc();
			$v_utilizado =  $row["utilizacao"];
            $v_data_exp = $row["dataexp"];
            $v_usuario = $row["id_usuario"];
		}
        
        if($result -> num_rows > 0 && $v_utilizado == 0 && $v_data_exp <= new DateTime('now')){
            $queryUpdate = "UPDATE cadastro_usuario SET senha = '" . $v_senhaCripto . "', confsenha = '" . $v_confsenhaCripto . "'  WHERE id_usuario = '" . $v_usuario . "'"; 
            $queryUpd = "UPDATE recuperacao_senha SET utilizacao = 1 WHERE token = '" . $v_token . "'"; 
            mysqli_query($mysqli,$queryUpdate);
            mysqli_query($mysqli,$queryUpd);
            echo 'Senha atualizada com sucesso';
        }
        else{
            echo 'Token Expirado';
        }
    }
    else{
        echo ($mysqli->error); 
        echo "Problema encontrado na recuperação da senha";
        
    }
}
else{
    echo "Token não informado"; 
}


$mysqli -> close();