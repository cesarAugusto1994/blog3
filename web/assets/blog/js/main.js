$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });

    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
});

function block_screen() {
    $('<div id="screenBlock"></div>').appendTo('body');
    $('#screenBlock').css( { opacity: 0, background: '#f6f6f6', width: $(document).width(), height: $(document).height() } );
    $('#screenBlock').addClass('blockDiv');
    $('#screenBlock').animate({opacity: 0.5}, 200);
}

function unblock_screen() {
    $('#screenBlock').animate({opacity: 0}, 200, function() {
        $('#screenBlock').remove();
    });
}