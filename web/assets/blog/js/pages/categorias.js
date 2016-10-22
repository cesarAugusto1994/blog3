/**
 * Created by cesar on 14/10/16.
 */

function editarCategoria(e)
{
    $("#confirmar").addClass('button is-success is-loading');
    
    e.preventDefault();

    block_screen();

    var id = $('#id').val();
    var nome = $('#nome').val();
    var colecao = $('#colecao').val();

    $.ajax({
        type: 'POST',
        url: '/admin/categoria/save',
        data: {
            'id' : id,
            'nome' : nome,
            'colecao' : colecao
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

