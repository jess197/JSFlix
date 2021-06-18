
$(document).ready(function () {

    $.ajax({
        type: 'GET', 
        url: '../php/getCartao.php', 
        success: function(result){
            result = JSON.parse(result);
             let datavalid = new Date(result['validcartao'].replace( /(\d{4})-(\d{2})-(\d{2})/, "$2/$3/$1"));
              $('#card-number').val(result['numcartao']);
              $('#card-month').val(datavalid.getMonth()+1);
              $('#card-year').val(datavalid.getFullYear());
              $('#card-cvc').val(result['codseg']);
              $('#card-holder').val(result['nametit']);
        }
    });


    let cardNumber, cardMonth, cardYear, cardCVC, cardHolder;
    
    function atualizarCartao(){
        $.ajax({
            type: 'POST', 
            url: '../php/updateCard.php',
            data: { 'cardNumber': cardNumber,
                    'cardMounth': cardMonth, 
                    'cardYear': cardYear, 
                    'cardCVC': cardCVC, 
                    'cardHolder': cardHolder, 
            }, 
            success: function(result){
                alert(result);
            },
            error: function(a,b,c){
                alert('Falha ao alterar os dados do cartão');
            }
        });
    }

    // on button click: 
    $('#card-btn').click(function (event) {

        cardNumber = $('#card-number').val();
        cardMonth = $('#card-month').val();
        cardYear = $('#card-year').val();
        cardCVC = $('#card-cvc').val();
        cardHolder = $('#card-holder').val();
        event.preventDefault();

        // alert the user if any fields are missing
        if (!cardNumber || !cardCVC || !cardHolder || !cardMonth || !cardYear) {
            alert("Os Campos estão vazios favor preencher");
        } else {
            atualizarCartao();
        }
    })

    

});

