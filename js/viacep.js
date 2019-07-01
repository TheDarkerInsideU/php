$(document).ready(function() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }

    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $( this ).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);

                    var acao = 'consulta_estado';

                    $.ajax({
                        url: '../estados/estados.php',
                        type: 'post',
                        data:{
                            uf : dados.uf,
                            acao
                        },
                        success: function(response){
                            $(".uf").val(response);
            
                            /*var acao = 'envia_estado';
                            var id_uf = response;

                            $.ajax({
                                url: '../modal_form.php',
                                type: 'post',
                                data:{
                                    id_uf,
                                    acao
                                },
                                success: function(response){
                                    $("#teste_envia").val("amem");
                                }
                            });*/


                        }
                    });
                    
                    } else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
                    } else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                    } else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
    });
    //Quando o campo cep perde o foco.
    $(".bgmin").click(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $( this ).attr('cep-id').replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);

                    var acao = 'consulta_estado';

                    $.ajax({
                        url: '../estados/estados.php',
                        type: 'post',
                        data:{
                            uf : dados.uf,
                            acao
                        },
                        success: function(response){
                            $(".uf").val(response);
                            $("#issoai").css("color", "red");
            
                            /*var acao = 'envia_estado';
                            var id_uf = response;

                            $.ajax({
                                url: '../modal_form.php',
                                type: 'post',
                                data:{
                                    id_uf,
                                    acao
                                },
                                success: function(response){
                                    $("#teste_envia").val("amem");
                                }
                            });*/


                        }
                    });
                    
                    } else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
                    } else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                    } else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
    });
});