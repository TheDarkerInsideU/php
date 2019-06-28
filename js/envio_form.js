$(document).ready(function(){

	$(".mudanca").click(function(){

		var id = $( this ).attr('data-id');

		var that = $( this ).attr('value');

		var acao = 'muda_status';

		$.ajax({
			url: 'modal_form.php',
			data: {
				'stat': that,
				'id': id,
				acao
			},
			type: "POST",
			dataType: 'html',
			success: function(response){
				window.location.reload();
			}
		});
	});

	$(".btn-form").bind('click',(function( e ){

		$('#modal').modal('show');

		e.preventDefault();
		var id = $( this ).attr('data-id');

		var edita = $( this ).attr('test-id');

		console.log('id: ', id);
		//$(".modal-body").load( "modal_form.php", { "id" : id}, function(){})
		$.ajax({
			url: 'modal_form.php',//coloque sua url aqui,
			data: {
				'id': id,
				'edita': edita,
			},
			type: "GET", //aqui você coloca GET
			dataType: 'html', //tipo de retorno que voê irá receber
			cache: false, //se irá fazer consulta no cache
			async: true, //se será assincrono ou sincrono
			beforeSend: function(xmlhttprequest) { //não obrigatório
			//faz alguma coisa antes de enviar o 
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { //não obrigatório
				//faz alguma coisa quando dá erro
				$('#modal3').modal('show');
			},
			success: function(response, status, xhr) {
				//faz alguma coisa quando dá certo
				// response é o resultado da requisição

				$('.modal-body').html(response); //estou pegando o resultado da requisição e colocando dentro do conteúdo do modal-body
			}
		});
	}));

	$('#btnHide').click(function(){
		$('#modal3').modal('hide');
	});

	$('#btnCancelar').click(function(){
		$('#modal').hide('fast').modal('hide');
	});

	$('#btnEnviar').click(function(){
		
		$.ajax({
			url: 'modal_form.php',//coloque sua url aqui,
			data: $('#formulando').serialize(),
			type: "POST", //aqui você coloca post
			dataType: 'html', //tipo de retorno que voê irá receber
			cache: false, //se irá fazer consulta no cache
			async: true, //se será assincrono ou sincrono
			beforeSend: function(xmlhttprequest) { //não obrigatório
			//faz alguma coisa antes de enviar o 
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { //não obrigatório
				
				$('#modal3').modal('show');
				//faz alguma coisa quando dá erro
			},
			success: function(response, status, xhr) {
				//faz alguma coisa quando dá certo
				// response é o resultado da requisição
				if( response == 'ok') {
					//redirecionamento para index.php via js
					$('#modal2').modal('show');
					//console.log(response);	
				} else {
					//caso n seja retornado ok, alerta um erro;
					$('#modal3').modal('show');
				}
			}
		});
	});

	$('#btnConfirmando').click(function(){
		window.location.reload()
	});
});