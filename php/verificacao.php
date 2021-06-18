<?php

$mysqli = new mysqli("localhost", "root", "root","cadastraUsuarios",3308); 

$contaValidada = false;

if($mysqli -> connect_errno){
    echo "Failed to connect to MySQL: ".$mysqli -> connect_error. 
    exit(); 
}

if(isset($_GET['token'])){
    $token = $_GET['token']; 
    if($token == ''){
        unset($token); 
    }
}

if(!empty($token)){
    if($result = $mysqli -> query("SELECT id_usuario FROM cadastro_usuario WHERE token = '" . $token . "'")){
        if($result -> num_rows > 0){
            $queryUpdate = "UPDATE cadastro_usuario SET confirmacao = 1 WHERE token = '" . $token . "'"; 
            mysqli_query($mysqli,$queryUpdate);
            $contaValidada = true;
        }
    }
    else{
        echo ($mysqli->error); 
        echo "<br> Problema encontrado na confirmação do cadastro<br>";
        
    }
}


$mysqli -> close();

?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<link rel="shortcut icon" href="../images/favicon.png" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
<link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<link href="../css/style-confirmacao.css" rel="stylesheet">
</head>
<body>
<div class="container">
<div class="card col-8">
  <div class="card-body">
<?php
    if($contaValidada){
     echo  
     '<h2>Cadastro na <img src="https://fontmeme.com/permalink/210405/9a10ff3e434e7259e0d8fcce5ee2bd62.png"> confirmado com sucesso</h2>
        <div class="text-center"> 
          <a class="txt2" href="../pages/login.html">Ir para o Login</a>
        </div>
        </div>
      </div>
      <br>
      <div>
      <img src="https://media2.giphy.com/media/3o7rc0qU6m5hneMsuc/giphy.gif?cid=ecf05e47r8ttzhl0wvipbjrkzsd0k1e1mgpememb9vai7ptu&rid=giphy.gif" id="img">
      </div>
      </div>';
    }else{
      echo '<h2><b>ERRO!</b> Houve um problema na confirmação do cadastro</h2>
        <div class="text-center"> 
          <a class="txt2" href="../pages/cadastro.html">Realizar cadastro</a>
        </div>
        </div>
      </div>
      <br>
      <div>
      <img src="https://media0.giphy.com/media/Ti77ZY8Ivj4PVFl6em/giphy.gif?cid=ecf05e47qgu6kf7q7wayx6zarur6hda4sobp13yn0jrad0h4&rid=giphy.gif" id="img">
      </div>
      </div>';

    }
?>
</body> 
</html>