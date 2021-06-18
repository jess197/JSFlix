<?php
	
	$v_email = $_POST['email'];
	$v_senha = $_POST['senha'];

	$v_senhaCripto = hash('sha256',$v_senha); 

	//inserir nome do banco definitivo na chamada abaixo, para testes foi usado "db_jsflix"
	$conn = mysqli_connect("localhost", "root", "root","cadastraUsuarios",3308);

	$cont=0;
	//Necessario alinhar variaveis abaixo com o banco final 
	$result = mysqli_query($conn,"SELECT * FROM cadastro_usuario WHERE email='$v_email' AND senha= '$v_senhaCripto'");

	if($result -> num_rows == 1){
		session_start();
		$registro = mysqli_fetch_assoc($result);
		if($registro['confirmacao'] == 1){
			$_SESSION["usuario"] = $registro;
			echo 1;
		}else{
			echo -1; 
		}


	}
	else{
		echo 0;
	}
	mysqli_close($conn);

?>