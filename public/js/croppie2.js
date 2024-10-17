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

	//Executar instrução quando usuário selecionar imagem
	$("#arquivo").on("change", function(){

		$("#preview").removeClass('d-none');
		$("#img").addClass('d-none');

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
		$(this).find('button[type="submit"]').addClass('disabled');

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