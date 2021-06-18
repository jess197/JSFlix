let nomeUsuario;
let filmes;

$(document).ready(function(){

  populaFilmes();

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
            window.location.href = "../pages/loginAdm.html";
        }
    });
  });

  $("#btnCadastrar").click(function(){
    

    let filme_titulo     = $('#filme_titulo').val()
    let filme_genero     = $('#filme_genero').val()
    let filme_ano        = $('#filme_ano').val()
    let filme_duracao    = $('#filme_duracao').val()
    let filme_relevancia = $('#filme_relevancia').val()
    let filme_sinopse    = $('#filme_sinopse').val()
    let filme_trailer    = $('#filme_trailer').val()

    if(
      filme_titulo == "" || filme_titulo == undefined ||
      filme_genero == "" || filme_genero == undefined ||
      filme_ano == "" || filme_ano == undefined ||
      filme_duracao == "" || filme_duracao == undefined ||
      filme_relevancia == "" || filme_relevancia == undefined ||
      filme_sinopse == "" || filme_sinopse == undefined ||
      filme_trailer == "" || filme_trailer == undefined
    ){
      alert("Favor preencher todos os campos do cadastro!");
      return;
    }

    var file_data = $('#filme_capa').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    form_data.append('filme_titulo', filme_titulo);
    form_data.append('filme_genero', filme_genero);
    form_data.append('filme_ano', filme_ano);
    form_data.append('filme_duracao', filme_duracao);
    form_data.append('filme_relevancia', filme_relevancia);
    form_data.append('filme_sinopse', filme_sinopse);
    form_data.append('filme_trailer', filme_trailer);
    console.log(form_data);                             


    $.ajax({
        type: 'POST', 
        url: '../php/cadastraFilme.php', 
        data:form_data,
        contentType:false,
        cache:false,
        processData:false,
        success: function(result){
          result = JSON.parse(result);
          if(result['sucesso']){
            populaFilmes();
            $("#exampleModal").modal('hide');

            $('#filme_titulo').val('')
            $('#filme_genero').val('')
            $('#filme_ano').val('')
            $('#filme_duracao').val('')
            $('#filme_relevancia').val('')
            $('#filme_sinopse').val('')
            $('#filme_trailer').val('')
          }else{
            alert(result['mensagem']);
          }
        },
        error: function(a,b,c){
          console.log("Error:",a,b,c);
        }
    });
  });

});

function fecharModal(){
  $("#exampleModal").modal('hide');
}

function populaFilmes(){
  $('#tbody').html("");
  $.ajax({
    type: 'GET', 
    url: '../php/getFilmes.php',
    success: function(result){
      filmes = JSON.parse(result);
      $.each(filmes,function(key,value){
        $('#tbody').append('<tr><th scope="row">' + value['id_filme'] + '</th><td>' + value['titulo'] + '</td><td>' + value['genero'] + '</td><td>' + value['ano'] + '</td><td>' + value['duracao'] + '</td><td>' + value['relevancia'] + ' % </td></tr>');
      });
    }
  });    
}