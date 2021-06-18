let filmes;
let nomeUsuario;

$(document).ready(function(){

    $.ajax({
        type: 'GET', 
        url: '../php/getFilmes.php',
        success: function(result){
          console.log(JSON.parse(result));
          filmes = JSON.parse(result);
          populaFilmes();
        }
    });

    $.ajax({
      type: 'GET', 
      url: '../php/getHome.php',
      success: function(result){
        if(result == ''){
          window.location.href = "../pages/login.html";
        }else{
          nomeUsuario = result;
        }
        $("#nomeUsuario").text('Olá, ' + nomeUsuario);
      }
  });

  
  $("#btnlogout").click(function(){
    $.ajax({
        type: 'GET', 
        url: '../php/logout.php', 
        success: function(){
            alert('Tchau!! Foi bom te ter aqui');
            window.location.href = "../pages/login.html";
        }
    });
  });
});

function favoritar(index, idfilme){
  filmes[index]['id_usuario'] = '1'
  $("#like").html('<div onClick="desfavoritar(' + index + ', ' + filmes[index]['id_filme'] + ')"><img src="https://img.icons8.com/fluent-systems-filled/24/26e07f/like.png"/></div>');
  $.ajax({
    type: 'POST', 
    url: '../php/addFavoritos.php',
    data: { 'id_filme': idfilme }, 
    success: function(result){
        alert('Favoritado com sucesso!');
        populaFilmes();
    }
  });
}


function desfavoritar(index, idfilme){
  filmes[index]['id_usuario'] = null
  $("#like").html('<div onClick="favoritar(' + index + ', ' + filmes[index]['id_filme'] + ')"><img src="https://img.icons8.com/material-outlined/24/26e07f/like--v1.png"/></div>');
  $.ajax({
    type: 'POST', 
    url: '../php/removeFavoritos.php',
    data: { 'id_filme': idfilme }, 
    success: function(result){
        alert('Desfavoritado com sucesso!');
        populaFilmes();
    }
  });
}

function populaFilmes(){
  $('#carousel').html('');
  $('#carousel-fav').html('');
   $.each(filmes,function(key,value){
     console.log(key,value);
     if(value['id_usuario'] == null){
      $('#carousel').append('<div class="pelicula"><a data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="preparaModal(' + key + ')" href="#"><img src="../images/' + value['imagem'] + '" alt=""></a></div>');
     }else{
      $('#carousel-fav').append('<div class="pelicula"><a data-bs-toggle="modal" data-bs-target="#exampleModal" onClick="preparaModal(' + key + ')" href="#"><img src="../images/' + value['imagem'] + '" alt=""></a></div>');
     }
  });

   preparaCarousel();
}

function preparaModal(index){
    //console.log(filmes[index]);

    $("#modalTituloFilme").text(filmes[index]['titulo']);
    $("#modalTrailerFilme").html(filmes[index]['trailer']);
    $("#modalGeneroFilme").html(filmes[index]['genero']);
    $("#modalAnoFilme").html("<p>" + filmes[index]['ano'] + ' ' + filmes[index]['relevancia'] + "% relevante " + filmes[index]['duracao'] + " minutos </p>");
    $("#modalSinopseFilme").html("<p>" + filmes[index]['sinopse'] + "</p>");
    
    if(filmes[index]['id_usuario'] != null){
      $("#like").html('<div onClick="desfavoritar(' + index + ', ' + filmes[index]['id_filme'] + ')"><img src="https://img.icons8.com/fluent-systems-filled/24/26e07f/like.png"/></div>');
    }else{
      $("#like").html('<div onClick="favoritar(' + index + ', ' + filmes[index]['id_filme'] + ')"><img src="https://img.icons8.com/material-outlined/24/26e07f/like--v1.png"/></div>');
    }

}

