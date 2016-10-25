/**
 * Created by cesar on 14/10/16.
 */

function removerArquivo(e) {

    e.preventDefault();

    var id = $(this).attr("anexo");

    alertify.confirm("Deseja remover este arquivo?", function(){

        block_screen();

        $.ajax({
            type: "POST",
            url: "/user/musica/"+id+"/anexos/remover",
            cache: false,
            success: function (data) {
                unblock_screen();
                window.location.reload();
            },
            error: function () {
                unblock_screen();
                alertify.error("Ocorreu um erro.");
            }
        });
    }).setting("labels",{"ok":"Sim", "cancel": "Cancelar"});
};

function upload(e)
{
    e.preventDefault();

    var id = $("#musica_id").val();
    $("#btn-upload").addClass("button is-success is-loading");

    block_screen();

    $.ajax({
        type: "POST",
        url: "/user/musica/"+id+"/anexos/upload",
        enctype: "multipart/form-data",
        data: new FormData( this ),
        processData: false,
        contentType: false,
        cache: false,
        success: function () {
            unblock_screen();
            window.location.reload();
        },
        error: function () {
            unblock_screen();
            $("#btn-upload").removeClass("is-loading");
            alertify.error("Ocorreu um erro.");
        }
    });
}

function addLink(e)
{
    e.preventDefault();

    var id = $("#musica_id").val();
    $("#btn-add-link").addClass("button is-success is-loading");

    block_screen();

    $.ajax({
        type: "POST",
        url: "/user/musica/"+id+"/anexos/save",
        enctype: "multipart/form-data",
        data: new FormData( this ),
        processData: false,
        contentType: false,
        cache: false,
        success: function () {
            unblock_screen();
            window.location.reload();
        },
        error: function () {
            unblock_screen();
            $("#btn-add-link").removeClass("is-loading");
            alertify.error("Ocorreu um erro.");
        }
    });

}

function criarComentario(e)
{
    e.preventDefault();

    var id = $("#musica_id").val();
    var comentario = $("#comentario").val();

    if("" == comentario) {
        alertify.error("Deve comentar algo.");
        $("#comentario").focus();
        return false;
    }

    $("#comentar").addClass("button is-success is-loading");

    $.ajax({
        type: "POST",
        url: "/user/musica/"+id+"/anexos/comentar",
        data : {
            "id" : id,
            "comentario" : comentario
        },
        cache: false,
        success: function (data) {
            unblock_screen();
            $("#comentar").removeClass("is-loading");
            $("#comentario").val("");
            window.location.reload();
        },
        error: function () {
            unblock_screen();
            alertify.error("Ocorreu um erro.");
        }
    });
}

function removerComentario(e) {

    e.preventDefault();
    
    var id = $(this).attr("comentario_id");

    alertify.confirm("Deseja remover este coment&aacute;rio?", function() {

        $(".remover-comentario").addClass("button is-danger is-loading");
        block_screen();

        $.ajax({
            type: "GET",
            url: "/user/musica/anexos/comentario/"+id+"/remover",
            cache: false,
            success: function () {
                unblock_screen();
                window.location.reload();
            },
            error: function () {
                unblock_screen();
                $(".remover-comentario").removeClass("is-loading");
                alertify.error("Ocorreu um erro.");
            }
        });
    }).setting("labels",{"ok":"Sim", "cancel": "Cancelar"});
};

$(document).ready(function () {
    $("#remover-arquivo").click(removerArquivo);
    $(".remover-comentario").click(removerComentario);
    //$("#form-comentario").submit(criarComentario);
    $("#form-upload").submit(upload);
    $("#form-add-link").submit(addLink);
});
