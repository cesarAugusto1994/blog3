/**
 * Created by cesar on 14/10/16.
 */

function mudarStatus(e) {

    e.preventDefault();

    var id = $(this).attr('colecao_id');

    alertify.confirm('Deseja Inativar esta Cole&ccedil;&atilde;o?', function(){

        block_screen();

        $.ajax({
            type: 'GET',
            url: '/admin/colecao/status/' + id,
            cache: false,
            success: function (data) {
                unblock_screen();
                $('#snackbarid').attr('data-content', data.message);
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

    var id = $('#id').val();
    var role = $('#role').val();
    var nome = $('#nome').val();
    var descricao = $('#descricao').val();

    $.ajax({
        type: 'POST',
        url: '/admin/colecao/save',
        data: {
            'id' : id,
            'role' : role,
            'nome' : nome,
            'descricao' : descricao
        },
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

$(document).ready(function () {
    $('.mudarStatus').on('click', mudarStatus);
    $('form').submit(editarColecao);
});
