$(document).ready(function(){

	
    $("#novaFoto img").on("click", function(){
		$("#arquivo").trigger("click");
	});

	var redimensionar = $('#preview').croppie({
	    enableExif: true,
	    enableOrientation: true,
	    viewport: {
	    	width: 180,
	    	height: 180,
	    	type: 'circle'
	    },
	    boundary: {
	    	width: 300,
	    	height: 300
	    }
	});

	$("#aplicar").on("click", function(){
		$("#modalContentEditarPerfil").removeClass('d-none');
		$("#modalContentAplicar").addClass('d-none');

		

	});

	//Executar instrução quando usuário selecionar imagem
	$("#arquivo").on("change", function(){

		//$("#preview").removeClass('d-none');
		//$("#img").addClass('d-none');
		$("#modalContentEditarPerfil").addClass('d-none');
		$("#modalContentAplicar").removeClass('d-none');

		//FileReader para ler de forma assincrona o conteúdo dos arquivos
		var reader = new FileReader();

		//onload - Execute após ler o conteúdo
		reader.onload = function(e){
			redimensionar.croppie('bind', {
				url: e.target.result
			})
		};

		//O método readAsDataURL lê conteúdos do tipo Blop ou File
		reader.readAsDataURL(this.files[0]);
	});

	$("#novaFoto").on("submit", function(e){
		e.preventDefault();
		//Desabilitar toques acidentais
		$(this).find('button[type="submit"]').addClass('disabled');
		$(this).find('img[id="img"]').addClass('disabled');
		$(this).find('input[id="arquivo"]').addClass('disabled');

		redimensionar.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(img){
			$.ajax({
				url: 'novaFoto',
				type: "POST",
				data: {
					"arquivo": img
				},
				dataType: 'json'
			}).done(function(result){
				//foto alterada com sucesso
				if(result == "done"){
					window.location.assign("perfil?uploads=done");
				}
			})
		})

	});

})