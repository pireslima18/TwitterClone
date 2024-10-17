$(document).ready(function(){

    var editarFoto = false;
    var editarNome = false;
    var imagemRedimensionada;
    var novoNome;

    //definindo croppie
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

    //dar um trigger no input file img
    $("#editarPerfil img").on("click", function(){
        $("#arquivo").trigger("click");
    });

    //botão voltar "editarperfil"
    $("#voltarEditarPerfil").on("click", function(){
        $("#modalContentAplicar").addClass('d-none');
        $("#modalContentEditarPerfil").removeClass('d-none');
    });

    // Executar instrução quando usuário selecionar imagem
    $("#editarNome").on("change", function(){
        editarNome = true;
        $('#submitEditarPerfil').removeClass('disabled');
        novoNome = $(this).val();
        console.log(novoNome);
    });

    // Executar instrução quando usuário selecionar imagem
    $("#arquivo").on("change", function(){
        $("#modalContentEditarPerfil").addClass('d-none');
        $("#modalContentAplicar").removeClass('d-none');

        var reader = new FileReader();

        reader.onload = function(e){
            redimensionar.croppie('bind', {
                url: e.target.result
            });
        };

        reader.readAsDataURL(this.files[0]);
    });


    //aplicar redimensionamento da nova foto
    $("#aplicar").on("click", function(){
        $("#modalContentEditarPerfil").removeClass('d-none');
        // Obter a versão redimensionada da imagem como uma URL
        redimensionar.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(img){
            // Definir a URL resultante no elemento #img-preview
            $('#img').attr('src', img);
            imagemRedimensionada = img;
        });

        editarFoto = true;
        $('#submitEditarPerfil').removeClass('disabled');

        $("#modalContentAplicar").addClass('d-none');

    });


    //enviar dados
    $("#editarPerfil").on("submit", function(e){
        e.preventDefault();
        $('#submitEditarPerfil').addClass('disabled');
        $(this).find('img[id="img"]').addClass('disabled');
        $(this).find('input[id="arquivo"]').addClass('disabled');
        $(this).find('input[id="editarNome"]').addClass('disabled');

        if(editarFoto && editarNome){
            $.ajax({
                url: 'editarPerfil',
                type: "POST",
                data: {
                    "arquivo": imagemRedimensionada,
                    "nome": novoNome
                },
                dataType: 'json'
            }).done(function(result){
                if(result == "done"){
                    window.location.assign("perfil");
                }
            });
        }
        if(editarFoto){
            $.ajax({
                url: 'editarPerfil',
                type: "POST",
                data: {
                    "arquivo": imagemRedimensionada
                },
                dataType: 'json'
            }).done(function(result){
                if(result == "done"){
                    window.location.assign("perfil");
                }
            });
        }
        if(editarNome){
            $.ajax({
                url: 'editarPerfil',
                type: "POST",
                data: {
                    "nome": novoNome
                },
                dataType: 'json'
            }).done(function(result){
                if(result == "done"){
                    window.location.assign("perfil");
                }
            });
        }

    });

});
