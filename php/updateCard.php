<?php
session_start();
$cardNumber     = $_POST['cardNumber'];
$cardMounth     = $_POST['cardMounth'];
$cardYear       = $_POST['cardYear'];
$cardCVC        = $_POST['cardCVC'];
$cardHolder     = $_POST['cardHolder'];

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

$queryUpdatePagamento = "UPDATE dados_pagamento SET numcartao = \"$cardNumber\", nametit = \"$cardHolder\", codseg = \"$cardCVC\",  validcartao = \"$cardYear-$cardMounth-01\" WHERE cpf = \"". $_SESSION["usuario"]["cpf"] ."\"";
mysqli_query($mysqli,$queryUpdatePagamento);

echo 'Dados atualizados com sucesso!';

$mysqli -> close();
?> 