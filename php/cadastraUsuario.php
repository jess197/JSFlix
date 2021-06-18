<?php
header ('Content-type: text/html; charset=iso-8859-1');
$v_nomecomp     = $_POST['fullname'];
$v_datanasc     = $_POST['datanasc'];
$v_email        = $_POST['email'];
$v_senha        = $_POST['inpassword'];
$v_confsenha    = $_POST['confpassword'];
$v_numcartao    = $_POST['numcartao'];
$v_validcartao  = $_POST['validcartao'];
$v_codseg       = $_POST['codseg'];
$v_nametit      = $_POST['nametit'];
$v_cpf          = $_POST['cpf'];
$v_tipo_plano   = $_POST['tipo_plano'];

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

$v_senhaCripto = hash('sha256',$v_senha); 
$v_confsenhaCripto = hash('sha256',$v_confsenha); 

function getToken($len=32){
    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
}
$token = getToken(10);

if($result = $mysqli -> query("SELECT cpf FROM dados_pagamento WHERE cpf = '" . $v_cpf . "'")){

    if($result -> num_rows < 1){
        $queryCadastro = "INSERT INTO cadastro_usuario(fullname,datanasc,email,senha,confsenha,cpf,tipo_plano,token) VALUES('".$v_nomecomp."','".$v_datanasc."','".$v_email."','".$v_senhaCripto."','".$v_confsenhaCripto."','".$v_cpf."','".$v_tipo_plano."','".$token."')";
        $queryPagamento = "INSERT INTO dados_pagamento(numcartao,validcartao,codseg,nametit,cpf) VALUES('".$v_numcartao."','".$v_validcartao."','".$v_codseg."','".$v_nametit."','".$v_cpf."')";
        mysqli_query($mysqli,$queryCadastro);
        mysqli_query($mysqli,$queryPagamento);
        
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
            $mail->addAddress($v_email, $v_nomecomp);                       //Add a recipient

            //Content
            $mail->isHTML(true);                                            //Set email format to HTML
            $mail->Subject = 'Cadastro realizado no JSFLix';
            $mail->Body    = 'Olá '.$v_nomecomp.', clique no link abaixo para confirmar a criação da sua conta. <br> <a href="http://localhost/jsflix/php/verificacao.php?token='.$token.'">Confirmar conta</a>';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ));
            if($mail->send()){
                $retorno['sucesso'] = true;
                $retorno['mensagem'] = 'Cadastro realizado com sucesso' . $queryCadastro;
            }
        } catch (Exception $e) {
            // echo "Erro ao enviar mensagem :{$mail->ErrorInfo}";
             $retorno['sucesso'] = false;
             $retorno['mensagem'] = 'Erro ao enviar o email de confirmação de conta';
        }

    }else{
        $retorno['sucesso'] = false;
        $retorno['mensagem'] = 'Já existe um cadastro com esse Email e/ou CPF';
    }
}
$mysqli -> close();
echo json_encode($retorno);

?> 