
$(document).ready(function(){

    $("#btnFiltrar").click(function(){
        $('#tbody').html("");
        $.ajax({
            type:'POST',
            dataType: "json",
            url: "../php/filtroFilmes.php",
            data: {'busca_filme': $('#busca_filme').val(),
                'busca_genero': $('#busca_genero').val(),
                'busca_ano': $('#busca_ano').val(),
                'busca_relevancia': $('#busca_rel').val()
            },
            success:function(filmes){
                $.each(filmes,function(key,value){
                $('#tbody').append('<tr><th scope="row">' + value['id_filme'] + '</th><td>' + value['titulo'] + '</td><td>' + value['genero'] + '</td><td>' + value['ano'] + '</td><td>' + value['duracao'] + '</td><td>' + value['relevancia'] + ' % </td></tr>');
                });
            }
      });
    });
    
});