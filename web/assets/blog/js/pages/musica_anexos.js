/**
 * Created by cesar on 14/10/16.
 */

function mudarStatus(e) {

    e.preventDefault();

    var id = $(this).attr('colecao_id');

    var situacao = 'Inativar';

    if (false == $(this).attr('situacao')) {
        situacao = 'Ativar';
    }

    alertify.confirm('Deseja ' + situacao + ' esta Cole&ccedil;&atilde;o?', function(){

        block_screen();

        $.ajax({
            type: 'GET',
            url: '/admin/colecao/status/' + id,
            cache: false,
            success: function (data) {
                unblock_screen();
                window.location.reload();
            },
            error: function () {
                unblock_screen();
                alertify.error('Ocorreu um erro.');
            }
        });
    }).setting('labels',{'ok':'Sim', 'cancel': 'Cancelar'});
};

function editarColecao(e)
{
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '/admin/colecao/save',
        enctype: 'multipart/form-data',
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
            alertify.error('Ocorreu um erro.');
        }
    });
}

function criarComentario(e)
{
    e.preventDefault();

    var id = $('#musica_id').val();
    var comentario = $('#comentario').val();

    if('' == comentario) {
        alertify.error('Deve comentar algo.');
        $('#comentario').focus();
        return false;
    }

    $.ajax({
        type: 'POST',
        url: '/user/musica/'+id+'/anexos/comentar',
        data : {
            'id' : id,
            'comentario' : comentario
        },
        cache: false,
        success: function (data) {
            unblock_screen();
            $('#comentario').val('');
            window.location.reload();
        },
        error: function () {
            unblock_screen();
            alertify.error('Ocorreu um erro.');
        }
    });
}

$(document).ready(function () {
    $('#form-comentario').submit(criarComentario);
});
