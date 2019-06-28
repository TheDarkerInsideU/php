$(document).ready(function(){

	$(".deleta").click(function(){
		var ids = $( this ).attr('value');

		$.ajax({
			method: 'POST',
			url: 'mysql_comands.php',
			data: {ids : ids},
			dataType: 'html',
			success: function(response){
				window.location.reload()
			},
			error: function(xhr, status, error){
				console.log('erro: ', xhr.responseText);
			}
		});
	})

	$(".edita").click(function(){

		var id = $( this ).attr('data-id');

		$("#salvando").attr('id', 'salva');

		console.log(id);

		$("#salva").click(function(e){

			e.preventDefault();

			var serializeDados = $('#formulario').serialize()+ '&' + $.param({id: id});

				$.ajax({
					method: 'POST',
					url: 'mysql_comands.php',
					data: serializeDados,
					dataType: 'html',
					success: function(response){
						$("#salva").attr('id', 'salvando');
						window.location.reload()
					},
					error: function(xhr, status, error){
						console.log('erro: ', xhr.responseText);
						$("#salvando").attr('id', 'salvando');
					}
				});
			});
		});

	$("#salvando").click(function(){

		$("#formulario").submit(function(e){

			var serializeDados = $('#formulario').serialize();

			e.preventDefault();

			$.ajax({
				method: 'POST',
				url: 'mysql_comands.php',
				data: serializeDados,
				success: function(response){
					window.location.reload()
				},
		        error: function(xhr, status, error) {
		            console.log('erro: ', xhr.responseText);
		        }
			});	
		});
	});

	$("#btn-volta-agr").click(function(){
		document.location.href = "../index.php";
	});
});