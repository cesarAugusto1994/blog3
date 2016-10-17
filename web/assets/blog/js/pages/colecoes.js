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

$(document).on('click', '.openMenu', function () {
    $('.modal-body #id').val($(this).data('id'));
    $('.modal-body #nome').val($(this).data('nome'));
    $('.modal-body #descricao').val($(this).data('descricao'));
});

$(document).on('click', '.addColecao', function () {
    $('.modal-body #id').val('');
    $('.modal-body #nome').val('');
    $('.modal-body #descricao').val('');
});

$(document).ready(function () {
    $('.mudarStatus').on('click', mudarStatus);
    $('form').submit(editarColecao);
});
