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

    var previewFoto;

    // Executar instrução quando usuário selecionar imagem
    $("#arquivo").on("change", function(){
        $("#modalContentEditarPerfil").addClass('d-none');
        $("#modalContentAplicar").removeClass('d-none');

        var reader = new FileReader();

        reader.onload = function(e){
            redimensionar.croppie('bind', {
                url: e.target.result
            });
            //previewFoto = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
    });

    $("#aplicar").on("click", function(){
        $("#modalContentEditarPerfil").removeClass('d-none');
        // Obter a versão redimensionada da imagem como uma URL
        redimensionar.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(img){
            // Definir a URL resultante no elemento #img-preview
            $('#img').attr('src', img);
            console.log(img)
        });
        $("#modalContentAplicar").addClass('d-none');

    });


    /*$("#novaFoto").on("submit", function(e){
        e.preventDefault();
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
                if(result == "done"){
                    window.location.assign("perfil?uploads=done");
                }
            });
        });
    });

});*/
