$(document).ready(function(){

    $("#btnsolRecuperacao").click(function(){
        $.ajax({
            type: 'POST', 
            url: '../php/solicitarecuperacao.php',
            data: { 'email': $('#email').val()
            }, 
            success: function(result){
                alert(result);
            }
        });
    });

    $("#btnRecuperacao").click(function(){
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        $.ajax({
            type: 'POST', 
            url: '../php/recuperarsenha.php',
            data: { 'email': $('#email').val(),
                    'inpassword': $('#inpassword').val(), 
                    'confpassword': $('#confpassword').val(), 
                    'token': token
            }, 
            success: function(result){
                alert(result);
            }
        });
    });
});