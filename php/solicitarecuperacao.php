<?php

$v_email = $_POST['email']; 

date_default_timezone_set('Etc/UTC');
require_once('./PHPMailer/src/PHPMailer.php');
require_once('./PHPMailer/src/SMTP.php'); 
require_once('./PHPMailer/src/Exception.php'); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

function getToken($len=32){
    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
}
$token = getToken(10);

if($result = $mysqli -> query("SELECT id_usuario FROM cadastro_usuario WHERE email = '" . $v_email . "'")){

		if($result -> num_rows < 1){
			echo 'Email não cadastrado';
		}else{
			$row = $result -> fetch_assoc();
			$v_id_usuario =  $row["id_usuario"];
		}

    if($result -> num_rows > 0){
        
        $queryRecuperacao = "INSERT INTO recuperacao_senha(token,id_usuario,datarec,dataexp,utilizacao) VALUES('".$token."','".$v_id_usuario."',now(),DATE_ADD(NOW(), INTERVAL 1 DAY),0)";
        mysqli_query($mysqli,$queryRecuperacao);
        
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                             //Enable verbose debug output
            $mail->isSMTP();                                                  //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                            //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                       //Enable SMTP authentication
            $mail->Username   = 'SEUEMAIL';          //SMTP username
            $mail->Password   = 'SUASENHA';                            //SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;  

            //Recipients
            $mail->setFrom('SEUEMAIL', 'Jsflix');
            $mail->addAddress($v_email, 'Usuário');                       //Add a recipient

            //Content
            $mail->isHTML(true);                                            //Set email format to HTML
            $mail->Subject = 'Recuperação de Senha JSFlix';
            $mail->Body    = 'Olá, clique no link abaixo para recuperar a senha da sua conta. <br> <a href="http://localhost/jsflix/pages/recuperarsenha.html?token='.$token.'">Recuperar Senha</a>';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ));
            if($mail->send()){
                /*
                $retorno['sucesso'] = true;
                $retorno['mensagem'] = 'Cadastro realizado com sucesso' . $queryCadastro;*/
                echo 'Email para recuperação de senha enviado com sucesso';
            }
        } catch (Exception $e) {
             echo "Erro ao enviar mensagem :{$mail->ErrorInfo}"; 
             /*
             $retorno['sucesso'] = false;
             $retorno['mensagem'] = 'Erro ao enviar o email de confirmação de conta';
             */
        }

    }else{
        echo ' Não existe conta com esse email na JSFlix';
        /*
        $retorno['sucesso'] = false;
        $retorno['mensagem'] = 'Já existe um cadastro com esse Email e/ou CPF';*/
    }
}
$mysqli -> close();
//echo json_encode($retorno);

?> 