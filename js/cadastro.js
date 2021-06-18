var planoSelecionado = '';

$(document).ready(function(){
    
    var formCadastro = false;

    $("#bronzeCard").click(function() {
        $("#bronzeCard").addClass('bronze');
        $("#silverCard").removeClass('silver');
        $("#goldCard").removeClass('gold');
        planoSelecionado = 'bronze'
    });
    
    $("#silverCard").click(function() {
        $("#silverCard").addClass('silver');
        $("#bronzeCard").removeClass('bronze');
        $("#goldCard").removeClass('gold');
        planoSelecionado = 'silver'
    });
    
    $("#goldCard").click(function() {
        $("#goldCard").addClass('gold');
        $("#bronzeCard").removeClass('bronze');
        $("#silverCard").removeClass('silver');
        planoSelecionado = 'gold'
    });

    $("#btnSelecionadoPlano").click(function() {
        if (planoSelecionado != ''){
            $('#nav-contact-tab').tab('show');
        }else{
            $("#divalertPlano").html('<div class="alert alert-danger alert-dismissible fade show" id="alertCadastro" role="alert"><strong>ERRO </strong>Favor selecione um plano<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
        }
    });

    $("#btnLimpar").click(function(){
        document.getElementById('numcartao').value='';
        document.getElementById('validcartao').value='';
        document.getElementById('codseg').value='';
        document.getElementById('nametit').value='';
        document.getElementById('cpf').value='';
    });
    

    var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab a'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        triggerEl.addEventListener('click', function (event) {
            //console.log(event);
            event.preventDefault()
            tabTrigger.show()
        })
    })



    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault()
            event.stopPropagation()
            if (!form.checkValidity()) {
                
                if(form.name == 'formCadastro'){
                    formCadastro = false;
                }

            }else{
                if(form.name == 'formCadastro'){
                    if(validarSenha()){
                        formCadastro = true;
                        $('#nav-profile-tab').tab('show');
                    }else{
                        formCadastro = false;
                    }
                }
                else{
                    if(validarCPF()){
                        if(formCadastro){
                            if(planoSelecionado != ''){
                                cadastrarUsuario();
                            }else{
                                $("#divalertPagamento").html('<div class="alert alert-danger alert-dismissible fade show" id="alertCadastro" role="alert"><strong>ERRO </strong>Favor selecione um plano<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
                            }
                        }else{
                            $("#divalertPagamento").html('<div class="alert alert-danger alert-dismissible fade show" id="alertCadastro" role="alert"><strong>ERRO </strong>Favor preencha corretamente os campos da conta<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
                        }
                    }
                    else{
                        $("#divalertPagamento").html('<div class="alert alert-danger alert-dismissible fade show" id="alertPagamento" role="alert"><strong>ERRO </strong>CPF Inválido! Favor preencher corretamente<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
                    }
                }
            }
            form.classList.add('was-validated')
        }, false)
    });
});


function validarSenha(){
    if($('#inpassword').val() != $('#confpassword').val()){
        $("#divalertCadastro").html('<div class="alert alert-danger alert-dismissible fade show" id="alertCadastro" role="alert"><strong>ERRO </strong>Senhas devem ser iguais<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
    }
    return $('#inpassword').val() == $('#confpassword').val();
}

function validarCPF() {
    var strCPF = $('#cpf').val().replaceAll(".","").replace("-","");
    var Soma;
    var Resto;
    Soma = 0;
  if (strCPF == "00000000000") return false;

  for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
  Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

  Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}


function cadastrarUsuario(){
    if(!validarSenha()){
        return;
    }
    $.ajax({
        type: 'POST', 
        url: '../php/cadastraUsuario.php',
        data: { 'fullname': $('#fullname').val(),
                'datanasc': $('#datanasc').val(), 
                'email': $('#email').val(), 
                'inpassword': $('#inpassword').val(), 
                'confpassword': $('#confpassword').val(), 
                'numcartao': $('#numcartao').val(), 
                'validcartao': $('#validcartao').val(), 
                'codseg': $('#codseg').val(), 
                'nametit': $('#nametit').val(), 
                'cpf': $('#cpf').val(),
                'tipo_plano': planoSelecionado
        }, 
        success: function(result){
            result = JSON.parse(result);
            if(!result.sucesso){
                $("#divalertPagamento").html('<div class="alert alert-danger alert-dismissible fade show" id="alertCadastro" role="alert"><strong>ERRO </strong>'+result.mensagem+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
            }else{
                $("#divalertPagamento").html('<div class="alert alert-success alert-dismissible fade show" id="alertCadastro" role="alert"><strong>SUCESSO </strong>Usuário cadastrado com sucesso<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'); 
            }
        }
    });
}










