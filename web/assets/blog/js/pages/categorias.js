/**
 * Created by cesar on 14/10/16.
 */

function mudarStatus(e) {

    e.preventDefault();

    var id = $(this).attr('categoria_id');

    var situacao = 'Inativar';

    if (false == $(this).attr('situacao')) {
        situacao = 'Ativar';
    }

    alertify.confirm('Deseja ' + situacao + ' esta Categoria?', function(){

        block_screen();

        $.ajax({
            type: 'GET',
            url: '/admin/categoria/' + id + '/status' ,
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

$(document).on('click', '.openMenu', function () {
    $('.modal-body #id').val($(this).data('id'));
    $('.modal-body #nome').val($(this).data('nome'));
    $('.modal-body #colecao').val($(this).data('colecao'));
    $('.modal-body #colecao').attr('selected', selected);
});

$(document).on('click', '.addCategoria', function () {
    $('.modal-body #id').val('');
    $('.modal-body #nome').val('');
    $('.modal-body #colecao').val('');
});

$(document).ready(function () {
    $('.mudarStatus').on('click', mudarStatus);
    $('form').submit(editarCategoria);
});
